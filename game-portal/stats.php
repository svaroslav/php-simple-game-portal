<?php
if (isset($_GET["app"])) {
    $query8 = $conn->prepare("select * from aplikace where id=?");
    $query8->bindParam(1, $_GET["app"], PDO::PARAM_INT);
    $query8->execute();
    $this_data = $query->fetch();
    echo '<h2>Statistika aplikace - ' . $this_data["display_nazev"] . '</h2>';
} else {
    if (isset($_GET["order"])) {
        $razeni = $_GET["order"];
    } else {
        $razeni = "username";
    }
    $query7 = $conn->prepare("select * from view_uspechy order by ?");
    $query7->bindParam(1, $razeni, PDO::PARAM_STR);
    $query7->execute();
    echo '<h2>Celková statistika</h2>
    <div class="container">            
  <table class="table table-hover">
    <thead>
      <tr>
        <th><a href="index.php?site=stats&order=username">Uživatel</a></th>
        <th><a href="index.php?site=stats&order=pocet">Splněno achievmentů</a></th>
        <th><a href="index.php?site=stats&order=soucet">Získáno Xp</a></th>
      </tr>
    </thead>
    <tbody>';
    foreach ($query7->fetchAll() as $row) {
//    echo $row["nazev"];
        echo '<tr>
        <td>' . $row["username"] . '</td>
        <td>' . $row["pocet"] . '</td>
        <td>' . $row["soucet"] . '</td>
      </tr>';
    }
    echo '</tbody>
  </table>
</div>';
    if (isset($_GET["my_order"])) {
        $my_razeni = $_GET["my_order"];
    } else {
        $my_razenirazeni = "datum";
    }
    $query9 = $conn->prepare("select achievmenty.datum as datum,typ_achievment.nazev as achievment,aplikace.display_nazev as aplikace,typ_achievment.pocet_xp as pocet from achievmenty,typ_achievment,aplikace where typ_achievment.id_aplikace = aplikace.id and achievmenty.id_achievment = typ_achievment.id and achievmenty.id_uzivatel=? order by ?");
    $query9->bindParam(1, $profil["id"], PDO::PARAM_INT);
    $query9->bindParam(2, $my_razeni, PDO::PARAM_STR);
    $query9->execute();
    echo '<h2>Moje ocenění</h2>
    <div class="container">            
  <table class="table table-hover">
    <thead>
      <tr>
        <th><a href="index.php?site=stats&my_order=datum">Datum</a></th>
        <th><a href="index.php?site=stats&my_order=aplikace">Aplikace</a></th>
        <th><a href="index.php?site=stats&my_order=achievment">Název achievmentu</a></th>
        <th><a href="index.php?site=stats&my_order=pocet">Hodnota Xp</a></th>
      </tr>
    </thead>
    <tbody>';
    foreach ($query9->fetchAll() as $row) {
        echo '<tr>
        <td>' . $row["datum"] . '</td>
        <td>' . $row["aplikace"] . '</td>
        <td>' . $row["achievment"] . '</td>
        <td>' . $row["pocet"] . '</td>
      </tr>';
    }
    echo '</tbody>
  </table>
</div>';
}
?>