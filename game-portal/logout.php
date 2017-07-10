<?php
//   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   
   $msg = "<div class='jumbotron'>Byl jsi úspěšně odhlášen!</div>";//nevim proc nefunguje
   echo '<h1><span class="label label-success">Byl jsi úspěšně odhlášen!</span></h1>';
   header('Refresh: 2; URL = index.php');
?>