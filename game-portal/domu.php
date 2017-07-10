<h2>Aktuality</h2>
<?php
$query4 = $conn->prepare("select * from aktuality order by datum");
$query4->execute();
if($query4->fetchColumn() < 1){
    echo '<div class="container">V této kategorii jsme bohužel nic nenašli <i class="em em-anguished"></i></div>'
    . '<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">';
}
 else {
    echo '<div class="container">
    <div class="row">';
foreach ($query4->fetchAll() as $row) {
    $query11 = $conn->prepare("select username from uzivatele where id=?");
    $query11->bindParam(1, $query4["id_izivatel"], PDO::PARAM_INT);
    $query11->execute();
    $temp_user = $query->fetch();
    echo '<div class="col-sm-6 col-md-4 col-lg-3">
        <div class="thumbnail">';
    if ($row["file_img"] != NULL) {
        echo '<a href="index.php?site=news&id=' . $row["id"] . '">
        <img width=300 height=300 src="' . $row["file_img"] . '" alt="' . $row["nazev"] . '">
        </a>';
    }
    echo '<div class="caption">
          <h3>' . $row["nazev"] . '</h3>
              <p>' . $row["datum"] . '<a href="index.php?site=profil&user_id=' . $row["id_uzivatel"] . '">' . $temp_user["username"] . '></a></p>
          <p>' . $row["text"] . '</p>
          <p><a href="index.php?site=news&id=' . $row["id"] . '">Více</a></p>
        </div>
      </div>
    </div>';
}
echo '</div>
</div>';
}
?>