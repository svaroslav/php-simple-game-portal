<?php
ob_start();
//session_start();
?>

<?
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
?>

<h2>Prosím, přihlaste se</h2>
<div class = "container form-signin">

    <?php
//    $msg = '';
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $query = $conn->prepare("select * from uzivatele where username=?");
//        $username = $_POST["username"];
        $query->bindParam(1, $_POST["username"], PDO::PARAM_STR);
        $query->execute();
        $data = $query->fetch();
//        if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
//        if ($passwd == $data["heslo"]) {
        if(password_verify($_POST['password'], $data["heslo"])){
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $_POST["username"];
//            header("Location: http://localhost:8080/game-portal/index.php");
            header('Location: index.php');
        } else {
            $msg = 'Špatné jméno nebo heslo!';
        }
    }
    ?>
</div>
<div class = "container">
    <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
        <input type = "text" 
               class = "form-control" 
               name = "username" 
               placeholder = "username = user / admin" 
               required autofocus></br>
        <input type = "password" 
               class = "form-control" 
               name = "password" 
               placeholder = "password = user / admin" 
               required>
        <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Přihlásit</button>
        <button class="btn btn-lg btn-default btn-block"><a href="index.php?site=register">Registrovat</a></button>
    </form>
</div>