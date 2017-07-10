<h2>Zaregistrujte se</h2>
<div class = "container form-signin">
    <?php
    $errors = false;
    $errUsername = false;
    $errHeslo = false;
    $errJmeno = false;
    $errPrijmeni = false;
    $errEmail = false;
    $errTelefon = false;
//    $msg = '';
    $count = 0;
//    if (isset($_POST['register']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['jmeno']) && !empty($_POST['prijmeni'])) {
    if (isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) && strlen($_POST["jmeno"]) >= 3 && strlen($_POST["prijmeni"]) >= 3 && strlen($_POST["email"]) >= 8 && strlen($_POST["username"]) >= 4 && strlen($_POST["password"]) >= 4) {
        if (strlen($_POST["jmeno"]) > 64) {
            $errors = true;
            $errJmeno = true;
        } else if (strlen($_POST["prijmeni"]) > 64) {
            $errors = true;
            $errPrijmeni = true;
        } else if (strlen($_POST["username"]) > 64) {
            $errors = true;
            $errUsername = true;
        } else if (strlen($_POST["password"]) > 64) {
            $errors = true;
            $errHeslo = true;
        } else if (strlen($_POST["email"]) > 64) {
            $errors = true;
            $errEmail = true;
        } else if (strlen($_POST["telefon"]) > 64) {
            $errors = true;
            $errTelefon = true;
        }
        if (isset($_POST["terms"]) && $errors == false) {
            $query = $conn->prepare("insert into uzivatele values(NULL, ?, ?, 1, ?, ?, ?, ?, ?, 'default.png')");
//        $username = $_POST["username"];
            $options = ['cost' => 11];
            $passwd = password_hash($_POST["password"], PASSWORD_BCRYPT, $options);
            $query->bindParam(1, $_POST["username"], PDO::PARAM_STR);
            $query->bindParam(2, $passwd, PDO::PARAM_STR);
            $query->bindParam(3, $_POST["jmeno"], PDO::PARAM_STR);
            $query->bindParam(4, $_POST["prijmeni"], PDO::PARAM_STR);
            $query->bindParam(5, $_POST["datum_narozeni"], PDO::PARAM_INT);
            $query->bindParam(6, $_POST["email"], PDO::PARAM_STR);
            $query->bindParam(7, $_POST["telefon"], PDO::PARAM_INT);
            if ($query->execute()) {
//            die("X");
                $msg = "Váš účet byl vytvořen!";
                header('Location: index.php?msg=registred');
            } else {
                echo 'Nezdařilo se!';
            }
        } else {
            echo "<h3><span class='label label-danger'>Musíte souhlasit s podmínkami!</span></h3>";
        }
    } else {
        if ($count != 0) {
            echo "Zadané údaje nesplňují podmínky pro registraci!";
            $count = 1;
        }
    }
    ?>
</div>
<div class = "container">
    <form class = "form-signin" method = "post">
        <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
        <label for="username">Uživatelské jméno</label>
        <?php
        if($errUsername){
            echo "<span class='label label-danger'>Uživatelské jméno je moc dlouhé!</span>";
        }
        ?>
        <input type = "text" 
               class = "form-control" 
               name = "username" 
               id = "username"
               placeholder = "username" 
               required autofocus>
        <label for="password">Vytvořit heslo</label>
        <?php
        if($errHeslo){
            echo "<span class='label label-danger'>Zadané heslo nespňuje některé parametry!</span>";
        }
        ?>
        <input type = "password" 
               class = "form-control" 
               name = "password" 
               id = "password"
               placeholder = "password" 
               required>
        <label for="jmeno">Jméno</label>
        <?php
        if($errJmeno){
            echo "<span class='label label-danger'>Vaše jméno je pro registraci moc dlouhé!</span>";
        }
        ?>
        <input type = "text" 
               class = "form-control" 
               name = "jmeno" 
               placeholder = "Karel" 
               required>
        <label for="prijmeni">Přijmení</label>
        <?php
        if($errPrijmeni){
            echo "<span class='label label-danger'>Vaše přijmení je pro registraci moc dlouhé!</span>";
        }
        ?>
        <input type = "text" 
               class = "form-control" 
               name = "prijmeni" 
               id = "prijmeni"
               placeholder = "Novák" 
               required>
        <label for="datum_narozeni">Datum narození</label>
        <input type = "date" 
               class = "form-control" 
               name = "datum_narozeni" 
               id = "datum_narozeni"
               placeholder = "12.12.2012" 
               required>
        <label for="email">Email</label>
        <?php
        if($errEmail){
            echo "<span class='label label-danger'>Zadaná Emailová adresa je moc dlouhá!</span>";
        }
        ?>
        <input type = "email" 
               class = "form-control" 
               name = "email" 
               id = "email"
               placeholder = "karel.novak@email.com" 
               required>
        <label for="telefon">Telefon</label>
        <?php
        if($errTelefon){
            echo "<span class='label label-danger'>Zadaný telefon je v neplatném formátu!</span>";
        }
        ?>
        <input type = "tel" 
               class = "form-control" 
               name = "telefon" 
               id = "telefon"
               placeholder = "123456789" 
               required>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="terms" class="form-check-input">
                Souhlasím s podmínkami
            </label>
        </div>
        <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "register">Registrovat</button>
        <button class="btn btn-lg btn-default btn-block"><a href="index.php">Přihlásit</a></button>
    </form>
</div>