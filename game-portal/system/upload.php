<head>
    <title>CHYBA - Game portal</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<?php
session_start();
require 'connect_db.php';
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<h3><span class='label label-danger'>Vybraný soubor není obrázek!</span></h3>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "<h3><span class='label label-danger'>Omlouváme se, ale soubor se stejným názvem již existuje! Pojmenujte soubor podle popisku!</span></h3>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "<h3><span class='label label-danger'>Omlouváme se, ale vybraný soubor je moc velký!</span></h3>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png"&& $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG"
&& $imageFileType != "gif" && $imageFileType != "GIF") {
    echo "<h3><span class='label label-danger'>Omlouváme se,ale jsou podporovány pouze soubory JPG, JPEG, PNG & GIF.</span></h3>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<h3><span class='label label-danger'> Váš soubor se nepodařilo uložit!</span></h3>";
        echo '<button class="btn btn-lg btn-primary btn-block"><a href="../index.php?site=profil">Zpět</a></button>';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $query = $conn->prepare("update uzivatele set " . "file_img = ? where username = ?");
        $query->bindParam(1, $_FILES["fileToUpload"]["name"], PDO::PARAM_STR);
        $query->bindParam(2, $_SESSION["username"], PDO::PARAM_STR);
        if ($query->execute()) {
            echo 'Uloženo!';
//            echo $_SESSION["username"];
//            echo $_FILES["fileToUpload"]["name"];
            header('Refresh: 0; URL = ../index.php?site=profil');
        } else {
            echo '<h3><span class="label label-danger">Nezdařilo se!</span></h3>';
        echo '<button class="btn btn-lg btn-default btn-block"><a href="../index.php?site=profil">Zpět</a></button>';
        }
    } else {
        echo "<h3><span class='label label-danger'>Nastala chyba při odesílání souboru!</span></h3>";
        echo '<button class="btn btn-lg btn-default btn-block"><a href="../index.php?site=profil">Zpět</a></button>';
    }
}
?>