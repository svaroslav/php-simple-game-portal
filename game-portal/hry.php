<h2>Hry</h2>
<?php
echo '<div class="container">
    <div class="row">';
$query2 = $conn->prepare("select * from aplikace order by id");
$query2->execute();
foreach ($query2->fetchAll() as $row) {
    echo '<div class="col-sm-6 col-md-4 col-lg-3">
      <div class="thumbnail">
        <a href="' . $row["href"] . '" target="blank">
        <img width=300 height=300 src="' . $row["file_img"] . '" alt="' . $row["nazev"] . '">
        </a>
        <div class="caption">
          <h3>' . $row["display_nazev"] . '</h3>
          <p>' . $row["popis"] . '</p>
          <p><a href="' . $row["href"] . '" target="blank" class="btn btn-primary" role="button">Hrát</a> <a href="index.php?site=stats&app=' . $row["id"] . '" class="btn btn-default" role="button">Žebříček</a> <a href="index.php?site=app&app=' . $row["id"] . '" class="btn btn-default" role="button">Více</a></p>
        </div>
      </div>
    </div>';
}
echo '</div>
</div>';
?>