<?php
if (isset($_GET["action"])) {
//    echo "editace je aktivni";
    if ($_GET["action"] == "edit") {
        $query = $conn->prepare("select * from aplikace where id=?");
        $query->bindParam(1, $_GET["table_id"], PDO::PARAM_INT);
        $query->execute();
        $app_data = $query->fetch();
        echo '<h2>Správa aplikace - ' . $app_data["display_nazev"] . '</h2>
<div class="container form-signin">
    <form method="post">
        <div class="form-group">
            <label for="display_nazev">Zobrazovaný název</label>
            <input type="text" 
                   class="form-control" 
                   id="display_nazev" 
                   name="display_nazev" 
                   value="' . $app_data["display_nazev"] . '" 
                   placeholder="Piškvorky">
        </div>
        <div class="form-group">
            <label for="nazev">Systémový název</label>
            <input type="text" 
                   class="form-control" 
                   id="nazev" 
                   name="nazev" 
                   value="' . $app_data["nazev"] . '"
                   placeholder="piskvorky">
        </div>
        <div class="form-group">
            <label for="href">Odkaz</label>
            <input type="text" 
                   class="form-control" 
                   id="href" 
                   name="href" 
                   value="' . $app_data["href"] . '"
                   placeholder="http://google.com/">
        </div>
        <div class="form-group">
            <label for="popis">Popis</label>
            <textarea class="form-control" 
                      rows="5" 
                      id="popis" 
                      name="popis" 
                      placeholder="Klasická hra s papírem a tužkou.">' . $app_data["popis"] . '</textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Uložit změny</button>
    </form>
        <button class="btn btn-default btn-block"><a href="index.php?site=mng_app">Zrušit</a></button>
</div>';
        if (isset($_POST["nazev"]) && isset($_POST["href"]) && isset($_POST["popis"])) {
            $query = $conn->prepare("update aplikace set nazev = ?,display_nazev = ?,href = ?, popis = ? where id = ?");
            $query->bindParam(1, $_POST["nazev"], PDO::PARAM_STR);
            $query->bindParam(2, $_POST["display_nazev"], PDO::PARAM_STR);
            $query->bindParam(3, $_POST["href"], PDO::PARAM_STR);
            $query->bindParam(4, $_POST["popis"], PDO::PARAM_STR);
            $query->bindParam(5, $app_data["id"], PDO::PARAM_INT);
            if ($query->execute()) {
                echo 'Uloženo!';
                header('Refresh: 0; URL = index.php?site=mng_app');
            } else {
                echo 'Nezdařilo se!';
            }
        }
    } else if ($_GET["action"] == "drop") {
        $query = $conn->prepare("delete from aplikace where id=?");
        $query->bindParam(1, $_GET["table_id"], PDO::PARAM_INT);
        if ($query->execute()) {
            echo 'Uloženo!';
            header('Refresh: 0; URL = index.php?site=mng_app');
        } else {
            echo 'Nezdařilo se!';
        }
    } else {
        echo "neplatny parametr";
    }
} else {
    $query = $conn->prepare("select * from aplikace order by id");
    $query->execute();
    echo '<h2>Správa aplikací</h2>';
    echo '<div class="container">
  <!--<h2>Hover Rows</h2>-->
  <!--<p>The .table-hover class enables a hover state on table rows:</p>-->            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Název</th>
        <th>Logo</th>
        <th>Upravit</th>
        <th>Odstranit</th>
      </tr>
    </thead>
    <tbody>';
    foreach ($query->fetchAll() as $row) {
//    echo $row["nazev"];
        echo '<tr>
        <td>' . $row["id"] . '</td>
        <td>' . $row["display_nazev"] . '</td>
        <td><img width=30 height=30 src="' . $row["file_img"] . '"></td>
        <td><a href="index.php?site=mng_app&action=edit&table_id=' . $row["id"] . '">Upravit</a></td>
        <td><a href="index.php?site=mng_app&action=drop&table_id=' . $row["id"] . '">Odstranit</a></td>
      </tr>';
    }
    echo '</tbody>
  </table>
</div>';
    echo '
        <h2>Přidat aplikaci</h2>
        <div class="container form-signin">
    <form method="post" action="system/mng_upload.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="display_nazev">Zobrazovaný název</label>
            <input type="text" 
                   class="form-control" 
                   id="display_nazev" 
                   name="display_nazev"
                   placeholder="Piškvorky">
        </div>
        <div class="form-group">
            <label for="mng_nazev">Systémový název</label>
            <input type="text" 
                   class="form-control" 
                   id="mng_nazev" 
                   name="nazev"
                   placeholder="piskvorky">
        </div>
        <div class="form-group">
            <label for="href">Odkaz</label>
            <input type="text" 
                   class="form-control" 
                   id="href" 
                   name="href"
                   placeholder="http://onlinehry.zubro.net/piskvorky/index.html">
        </div>
        <div class="form-group">
            <label for="popis">Popis</label>
            <textarea class="form-control" 
                      rows="5" 
                      id="popis" 
                      name="popis" 
                      placeholder="Klasická hra s papírem a tužkou."></textarea>
        </div>
        <div class="form-group">
            <label for="fileToUploadMng">Přidat obrázek</label>
            <input type="file" class="form-control-file" id="fileToUploadMng" name="fileToUploadMng" aria-describedby="fileHelpMng">
            <small id="fileHelpMng" class="form-text text-muted">Soubor musí být obrázek (JPG, JPEG, PNG, GIF) a nesmí přesáhnout velikost 5 MB.</small>
        </div>
        <button type="submit" class="btn btn-primary">Vytvořit</button>
    </form>
</div>';
}
?>