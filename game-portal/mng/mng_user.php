<?php
if (isset($_GET["action"])) {
    if ($_GET["action"] == "edit") {
        $query = $conn->prepare("select * from uzivatele where id=?");
        $query->bindParam(1, $_GET["table_id"], PDO::PARAM_INT);
        $query->execute();
        $app_data = $query->fetch();
        echo '<h2>Správa uživatele - ' . $app_data["username"] . '</h2>
<div class="container form-signin">
    <form method="post">
        <div class="form-group">
            <label for="jmeno">Jméno</label>
            <input type="text" 
                   class="form-control" 
                   id="jmeno" 
                   name="jmeno" 
                   value="' . $app_data["jmeno"] . '" 
                   placeholder="Karel">
        </div>
        <div class="form-group">
            <label for="prijmeni">Přijmení</label>
            <input type="text" 
                   class="form-control" 
                   id="prijmeni" 
                   name="prijmeni" 
                   value="' . $app_data["prijmeni"] . '"
                   placeholder="Novák">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" 
                   class="form-control" 
                   id="email" 
                   name="email" 
                   value="' . $app_data["email"] . '"
                   placeholder="karel.novak@email.com">
        </div>
        <div class="form-group">
            <label for="telefon">Telefon</label>
            <input type="tel" 
                   class="form-control" 
                   id="telefon" 
                   name="telefon" 
                   value="' . $app_data["telefon"] . '"
                   placeholder="123456789">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Uložit změny</button>
    </form>
        <button class="btn btn-default btn-block"><a href="index.php?site=mng_user">Zrušit</a></button>
</div>';
        if (isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["email"]) && isset($_POST["telefon"])) {
            $query = $conn->prepare("update uzivatele set jmeno = ?,prijmeni = ?,email = ?, telefon = ? where id = ?");
            $query->bindParam(1, $_POST["jmeno"], PDO::PARAM_STR);
            $query->bindParam(2, $_POST["prijmeni"], PDO::PARAM_STR);
            $query->bindParam(3, $_POST["email"], PDO::PARAM_STR);
            $query->bindParam(4, $_POST["telefon"], PDO::PARAM_INT);
            $query->bindParam(5, $app_data["id"], PDO::PARAM_INT);
            if ($query->execute()) {
                echo 'Uloženo!';
                header('Refresh: 0; URL = index.php?site=mng_user');
            } else {
                echo 'Nezdařilo se!';
            }
        }
    } else if ($_GET["action"] == "drop") {
        $query = $conn->prepare("delete from uzivatele where id=?");
        $query->bindParam(1, $_GET["table_id"], PDO::PARAM_INT);
        if ($query->execute()) {
            echo 'Uloženo!';
            header('Refresh: 0; URL = index.php?site=mng_user');
        } else {
            echo 'Nezdařilo se!';
        }
    } else {
        echo "neplatny parametr";
    }
} else {
    $query = $conn->prepare("select * from uzivatele order by id");
    $query->execute();
    echo '<div class="container">
  <!--<h2>Hover Rows</h2>-->
  <!--<p>The .table-hover class enables a hover state on table rows:</p>-->            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Fotka</th>
        <th>Jméno</th>
        <th>Přijmení</th>
        <th>Email</th>
        <th>Telefon</th>
        <th>Upravit</th>
        <th>Odstranit</th>
      </tr>
    </thead>
    <tbody>';
    foreach ($query->fetchAll() as $row) {
//    echo $row["nazev"];
        echo '<tr>
        <td>' . $row["id"] . '</td>
        <td>' . $row["username"] . '</td>
        <td><img width=30 height=30 src="uploads/' . $row["file_img"] . '"></td>
        <td>' . $row["jmeno"] . '</td>
        <td>' . $row["prijmeni"] . '</td>
        <td>' . $row["email"] . '</td>
        <td>' . $row["telefon"] . '</td>
        <td><a href="index.php?site=mng_user&action=edit&table_id=' . $row["id"] . '">Upravit</a></td>
        <td><a href="index.php?site=mng_user&action=drop&table_id=' . $row["id"] . '">Odstranit</a></td>
      </tr>';
    }
    echo '</tbody>
  </table>
</div>';
}
?>