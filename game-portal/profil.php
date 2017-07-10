<!--<h2>Profil</h2>-->
<?php
//if(isset($_GET["id"]) && is_numeric($_GET["id"])){
//    $id = (int) $_GET["id"];
//}
//else{
//    $id = NULL;
//}
//if ($id != NULL) {
//    $query = $conn->prepare("select * from uzivatele where username=?");
//    $query->bindParam(1, $username, PDO::PARAM_INT);
//    $query->execute();
//    $profil = $query->fetch();
if ($profil) {
//    echo "Upravuješ profil - " . $profil["username"] . "<br>";
} else {
    die("Nepovedlo se upravit profil!");
}
//}
if (isset($_POST['jmeno']) && isset($_POST['prijmeni']) && isset($_POST['jmeno'])) {
    if (strlen($_POST["jmeno"]) < 3 || strlen($_POST["prijmeni"]) < 3 || strlen($_POST["email"]) < 8) {
        echo 'Zadané parametry nesplňují nastavená pravidla!';
    } else {
        $jmeno = filter_var($_POST["jmeno"], FILTER_SANITIZE_STRING);
        $prijmeni = filter_var($_POST["prijmeni"], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $telefon = filter_var($_POST["telefon"], FILTER_SANITIZE_NUMBER_INT);
//        if($id == NULL){
//            $query = $conn->prepare("insert into uzivatele values (null, ?, ?, ?, ?)");
//        $query->bindParam(1, $nazev, PDO::PARAM_STR);
//        }
//        else{
        $query = $conn->prepare("update uzivatele set " . "jmeno = ?,prijmeni = ?,telefon = ?, email = ? where username = ?");
        $query->bindParam(1, $jmeno, PDO::PARAM_STR);
        $query->bindParam(2, $prijmeni, PDO::PARAM_STR);
        $query->bindParam(3, $telefon, PDO::PARAM_INT);
        $query->bindParam(4, $email, PDO::PARAM_STR);
        $query->bindParam(5, $username, PDO::PARAM_STR);
        if ($query->execute()) {
            echo 'Uloženo!';
            header('Refresh: 0; URL = index.php?site=profil');
        } else {
            echo 'Nezdařilo se!';
        }
    }
}
?>
<!--<form method="post">
    <label for="jmeno">
        Jméno
    </label>
    <input 
        placeholder="Pavel" 
        type="text" 
        name="jmeno" 
        id="jmeno" 
        <?php
//        echo 'value="' . $profil["jmeno"] . '"';
        ?>
        required="required"
        >
    <br>
    <label for="prijmeni">
        Přijmení
    </label>
    <input 
        placeholder="Novák" 
        type="text" 
        name="prijmeni" 
        id="prijmeni" 
        <?php
//        echo 'value="' . $profil["prijmeni"] . '"';
        ?>
        required="required"
        >
    <br>
    <label for="email">
        Email
    </label>
    <input 
        placeholder="uzivatel@server.domena" 
        type="text" 
        name="email" 
        id="email" 
        <?php
//        echo 'value="' . $profil["email"] . '"';
        ?>
        required="required"
        >
    <br>
    <label for="telefon">
        Telefon
    </label>
    <input 
        placeholder="123456789" 
        type="number" 
        name="telefon" 
        id="telefon" 
        <?php
//        echo 'value="' . $profil["telefon"] . '"';
        ?>
        required="required"
        >
    <br>
    <button type="submit"><strong>Odeslat</strong></button>
</form>-->
<h2>Správa profilu - <?php echo $profil["username"] ?></h2>
<div class="container form-signin">
    <form method="post">
        <div class="form-group">
            <label for="jmeno">Jméno</label>
            <input type="text" 
                   class="form-control" 
                   id="jmeno" 
                   name="jmeno"
                   <?php
                    echo 'value="' . $profil["jmeno"] . '"';
                   ?>
                   aria-describedby="emailHelp" 
                   placeholder="Karel">
        </div>
        <div class="form-group">
            <label for="prijmeni">Přijmení</label>
            <input type="text" 
                   class="form-control" 
                   id="prijmeni" 
                   name="prijmeni"
                   <?php
                    echo 'value="' . $profil["prijmeni"] . '"';
                   ?>
                   aria-describedby="emailHelp" 
                   placeholder="Novák">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" 
                   class="form-control" 
                   id="email" 
                   name="email"
                   <?php
                    echo 'value="' . $profil["email"] . '"';
                   ?>
                   aria-describedby="emailHelp" 
                   placeholder="karel.novak@email.com">
        </div>
        <div class="form-group">
            <label for="telefon">Telefon</label>
            <input type="tel" 
                   class="form-control" 
                   id="telefon" 
                   name="telefon" 
                   <?php
                    echo 'value="' . $profil["telefon"] . '"';
                   ?>
                   aria-describedby="emailHelp" 
                   placeholder="123456789">
        </div>
<!--        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>-->
        <button type="submit" class="btn btn-primary">Uložit</button>
    </form>
    <br>
    <div class="row">
        <div style="width: 100%;">
    <div class="thumbnail">
      <?php
    echo "<img width='300' height='300' src='uploads/" . $profil["file_img"] . "' alt='Profilový obrázek uživatele " . $profil["username"] . ".'>";
    ?>
      <div class="caption">
        <form method="post" action="system/upload.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileToUpload">Změnit profilový obrázek</label>
            <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload" aria-describedby="fileHelp">
            <small id="fileHelp" class="form-text text-muted">Soubor musí být obrázek (JPG, JPEG, PNG, GIF) a nesmí přesáhnout velikost 1 MB. Nejlepší rozlišení je 300x300 px.</small>
        </div>
        <button type="submit" class="btn btn-primary">Uložit</button>
    </form>
      </div>
    </div>
  </div>
</div>
</div>