<!DOCTYPE html>
<?php
session_start();
$msg = '';
$username = "*empty*";
$id = 0;
$logged = true;
require 'system/connect_db.php';
if (isset($_SESSION["username"])) {
//    echo $_SESSION["username"];
    $username = $_SESSION["username"];
    $query = $conn->prepare("select * from uzivatele where username=?");
    $query->bindParam(1, $username, PDO::PARAM_INT);
    $query->execute();
    $profil = $query->fetch();
    if (isset($_GET["site"])) {
        if ($profil["id_typ_uctu"] == 2) {
            switch ($_GET["site"]) {
                case "profil":
                    $site = "profil.php";
                    break;
                case "mng_app":
                    $site = "mng/mng_app.php";
                    break;
                case "mng_user":
                    $site = "mng/mng_user.php";
                    break;
                case "hry":
                    $site = "hry.php";
                    break;
                case "stats":
                    $site = "stats.php";
                    break;
                case "app":
                    $site = "app.php";
                    break;
                case "logout":
                    $site = "logout.php";
                    break;
                default :
                    $site = "domu.php";
            }
        } else {
            switch ($_GET["site"]) {
                case "profil":
                    $site = "profil.php";
                    break;
                case "hry":
                    $site = "hry.php";
                    break;
                case "stats":
                    $site = "stats.php";
                    break;
                case "app":
                    $site = "app.php";
                    break;
                case "logout":
                    $site = "logout.php";
                    break;
                default :
                    $site = "domu.php";
            }
        }
    } else {
        $site = "domu.php";
    }
//    $query = $conn->prepare("select * from uzivatele where id=?");
//    $query->bindParam(1, $id, PDO::PARAM_INT);
//    $query->execute();
//    $profil = $query->fetch();
} else {
    if (isset($_GET["site"])) {
        if ($_GET["site"] == "register") {
            $site = "register.php";
        } else {
            $site = "login.php";
        }
    } else {
        $site = "login.php";
        //echo "neznamy uzivatel";
    }
}
?>
<html>
    <head>
        <title>Game portal</title>
        <link href = "system/css/bootstrap.css" rel = "stylesheet">
        <link href="system/css/main.css" rel="stylesheet">
        <link href="http://onlinehry.zubro.net/main.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if ($username != "*empty*") {
//            echo '
//        <nav class="navbar navbar-default navbar-fixed-top">
//        <div class="container">
//        <div class="navbar-header">
//            <a href="index.php?site=domu">Domů</a>
//            <a href="index.php?site=hry">Hry</a>
//        </div>
//        <div>
//            <a href="index.php?site=profil">' . $profil["jmeno"] . ' ' . $profil["prijmeni"] . '</a>
//            <a href="index.php?site=logout">Odhlásit</a>
//        </div>
//        </div>
//        </nav>
//        ';
            echo "<nav class='navbar navbar-default'>
  <div class='container-fluid'>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class='navbar-header'>
      <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1' aria-expanded='false'>
        <span class='sr-only'>Toggle navigation</span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
      </button>
        <a class='navbar-brand' href='index.php'>Game portal</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
      <ul class='nav navbar-nav'>
          <li><a href='index.php?site=hry'><span class='glyphicon glyphicon-th' aria-hidden='true'></span> Hry</a></li>
        <li><a href='index.php?site=stats'><span class='glyphicon glyphicon-stats' aria-hidden='true'></span> Statistiky</a></li>";
            if ($profil["id_typ_uctu"] == 2) {
                echo "<li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Administrace <span class='caret'></span></a>
                            <ul class='dropdown-menu'>
                                <li><a href='index.php?site=mng_app'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span> Správa aplikací</a></li>
                                <li><a href='index.php?site=mng_user'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span> Správa uživatelů</a></li>
                            </ul>
                        </li>";
            }
            echo "</ul>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='index.php?site=profil'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> " . $profil["jmeno"] . ' ' . $profil["prijmeni"] . "</a></li>
        <li><a href='index.php?site=logout'><span class='glyphicon glyphicon-off' aria-hidden='true'></span> Odhlásit</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>";
        }
        include_once $site;
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="system/js/bootstrap.js"></script>
    </body>
</html>