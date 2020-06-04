<?php

class gradeAdmin
{
    public function deactivate(connexion $connexion)
    {
        $id = $_GET['id'];
        $requeteSQL = "UPDATE `account` SET `deactivate` = 'oui' WHERE `account`.`id` = $id;";
        $sth = $connexion->dbco->prepare($requeteSQL);
        $sth->execute();
    }

    public function administration(connexion $connexion)
    {
        $requeteSql = "SELECT `id`, `nom`, `prenom`, `login`, `password`, `id_privilege`, `is_handicapped`, `deactivate` 
        FROM `account` WHERE `id_privilege` <> '2' AND `deactivate` <> 'oui'";
        $sth = $connexion->dbco->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<center><div style='max-width: 97%;'>
        <table class='table table-hover'>
        <thead>
          <tr>
              <th scope='col'>Nom</th>
              <th scope='col'>Prénom</th>
              <th scope='col'>Email</th>
              <th scope='col'></th>
              </tr>
        </thead>";
        foreach ($result as $row) {
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['login'];
            echo "<tbody>
             <tr>
            <td>$nom</td>
            <td>$prenom</td>
            <td>$email</td>
            <td>";
            $id = $row['id'];
            echo "<a href='deactivate.php?id=$id'>
                        <button type='button' class='btn btn-warning'>Désactiver</button></a>";
            echo "</td>
            </tr>
            </tbody>";
        }
        echo "</table></div></center>";


    }

    public function createUser(connexion $connexion)
    {
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='create_user_admin.php' novalidate>
        <div class='form-row'>
         <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Nom</label>
            <input type='text' name='nom' class='form-control' id='validationCustom01' placeholder='Nom' required>
        </div>
         <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Prénom</label>
            <input type='text' name='prenom' class='form-control' id='validationCustom01' placeholder='Prenom' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Email</label>
            <input type='email' name='login' class='form-control' id='validationCustom01' placeholder='Email' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Mot de passe</label>
            <input type='password' name='password' class='form-control' placeholder='Mot de passe' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label>Grade</label>";
        $requeteSql = "SELECT * FROM `privilege`";
        $sth = $connexion->dbco->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<select class='custom-select' name='id_privilege' required>";
        foreach ($result as $row) {
            echo "<option>" . utf8_encode($row['wording']) . "</option>";
        }
        echo "</select></div></div>
        <p>L'utilisateur a t'il un handicap visuel ?</p>
        <input type='radio' name='radio' value='oui'>oui
        <input type='radio' name='radio' value='non'>non";
        echo "<br><br><button class='btn btn-primary' type='submit'>Ajouter l utilisateur</button></form></div></center>";
        if (isset($_POST['login']) and $_POST['login'] !== '' and $_POST['login'] !== null) {
            $login = $_POST['login'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $password = $_POST['password'];
            $idPrivilege = $_POST['id_privilege'];
            if ($idPrivilege == 'user') {
                $idPrivilege = '1';
            } elseif ($idPrivilege == 'administrator') {
                $idPrivilege = '2';
            }
            if ($_POST['radio'] == 'oui') {
                $isHandicapped = 'oui';
            } elseif ($_POST['radio'] == 'non') {
                $isHandicapped = 'non';
            }
            $requeteSql = "INSERT INTO `account` (`id`, `nom`, `prenom`, `login`, `password`, `id_privilege`, `is_handicapped`, `deactivate`) 
            VALUES (NULL, '$nom', '$prenom', '$login', '$password', '$idPrivilege', '$isHandicapped', 'non');";
            $sth = $connexion->dbco->prepare($requeteSql);
            $sth->execute();
        }
    }

    public function addProject(connexion $connexion)
    {
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='add_projet_admin.php' novalidate>
        <div class='form-row'>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Création de projet</label>
            <input type='text' name='nom_projet' class='form-control' id='validationCustom01' placeholder='Nom du projet' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label>Attribution</label>";
        $requeteSql = "SELECT * FROM `account`";
        $sth = $connexion->dbco->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<select class='custom-select' required name='attribution'>";
        foreach ($result as $row) {
            echo "<option>" . $row['login'] . "</option>";
        }
        echo "</select></div>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Date de début</label>
            <input type='date' name='date_debut' class='form-control' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Date de fin</label>
            <input type='date' name='date_fin' class='form-control' required>
        </div>
        </div>
        <button class='btn btn-primary' type='submit'>Ajouter le projet</button>
        </form>
        </div>
        </center>";
        if (isset($_POST['nom_projet']) and $_POST['nom_projet'] !== '' and $_POST['nom_projet'] !== null) {
            $nomProjet = $_POST['nom_projet'];
            $attribution = $_POST['attribution'];
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];
            $requeteSql = "INSERT INTO `projet` (`id`, `nom_projet`, `attribution`, `date_debut`, `date_fin`)
            VALUES (NULL, '$nomProjet', '$attribution', '$dateDebut', '$dateFin');";
            $sth = $connexion->dbco->prepare($requeteSql);
            $sth->execute();
        }
    }

    public function deleteProject(connexion $connexion)
    {
        $id = $_GET['id'];
        $requeteSQL = "DELETE FROM `projet` WHERE `id`= '$id';";
        $sth = $connexion->dbco->prepare($requeteSQL);
        $sth->execute();
    }

    public function list_project(connexion $connexion)
    {
        $login = $_SESSION['login'];
        $requeteSql = "SELECT `id`, `nom_projet`, `attribution`, `date_debut`, `date_fin` FROM `projet` WHERE `attribution` = '$login';";
        $sth = $connexion->dbco->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<center><div style='max-width: 97%;'>
        <table class='table table-hover'>
        <thead>
          <tr>
              <th scope='col'>Nom du projet</th>
              <th scope='col'>Attribution</th>
              <th scope='col'>Date de début</th>
              <th scope='col'>Progression</th>
              <th scope='col'>Date de fin</th>
              <th scope='col'></th>
              <th scope='col'></th>
              </tr>
        </thead>";
        foreach ($result as $row) {
            $nom_projet = $row['nom_projet'];
            $attribution = $row['attribution'];
            $date_debut = $row['date_debut'];
            $date_fin = $row['date_fin'];
            $dateFin = $rest = substr($date_fin, 0, -9);
            $dateDebut = $rest = substr($date_debut, 0, -9);
            $width = 60;
            if ($dateFin == date('Y-m-d')){
                $width = 100;
            } elseif ($dateDebut == date('Y-m-d')){
                $width = 10;
            }
            $progression = "<div class='progress'>
            <div class='progress-bar-animated progress-bar-striped bg-success' role='progressbar' style='width: $width%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
            </div>";
            echo "<tbody>
             <tr>
            <td>$nom_projet</td>
            <td>$attribution</td>
            <td>$date_debut</td>
            <td>$progression</td>
            <td>$date_fin</td>
            <td>";
            $nom_projet = $row['nom_projet'];
            $attribution = $row['attribution'];
            $date_debut = $row['date_debut'];
            $date_fin = $row['date_fin'];
            $id = $row['id'];
            echo "<a href='modification_projet_admin.php?nom_projet=$nom_projet&attribution=$attribution&date_debut=$date_debut&date_fin=$date_fin&id=$id'>
                        <button type='button' class='btn btn-warning'>Modifier</button></a>";
            echo "</td><td>";
            $id = $row['id'];
            echo "<a href='delete_projet.php?id=$id'><button type='button' class='btn btn-danger'>Supprimer</button></a>
            </td>
            </tr>
            </tbody>";
        }
        echo "</table></div></center>";
    }

    public function modificationProject(connexion $connexion)
    {
        $id = $_GET['id'];
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='modification_projet_admin_confirm.php?id=$id' novalidate>";
        $nom_projet = $_GET['nom_projet'];
        echo "<div class='form-row'>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Nom du projet</label>
            <input type='text' name='nom_projet' class='form-control' id='validationCustom01' value='$nom_projet'>
        </div>";
        $requeteSql = "SELECT * FROM `account`";
        $sth = $connexion->dbco->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>Attribution</label>
        <select class='custom-select' name='attribution'>";
        foreach ($result as $row) {
            $attribution = $_GET['attribution'];
            echo "<option value='$attribution'>" . $row['login'] . "</option>";
        }
        echo "</select></div>";
        $date_debut = $_GET['date_debut'];
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>Date de début</label>
        <input type='text' name='date_debut' class='form-control' id='validationCustom01' value='$date_debut'></div>";
        $date_fin = $_GET['date_fin'];
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>Date de fin</label>
        <input type='text' name='date_fin' class='form-control' id='validationCustom01' value='$date_fin'></div></div>";
        echo "<button class='btn btn-success' type='submit'>Modifier le projet</button>";
        echo '</form></center>';
    }

    public function modificationProjectConfirm(connexion $connexion)
    {
        $id = $_GET['id'];
        if (isset($_POST['nom_projet'])
            and $_POST['nom_projet'] !== ''
            and $_POST['nom_projet'] !== null) {
            $nomProjet = $_POST['nom_projet'];
            $attribution = $_POST['attribution'];
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];
            $requeteSql = "UPDATE `projet` SET `nom_projet` = '$nomProjet', `attribution` = '$attribution', `date_debut` = '$dateDebut', `date_fin` = '$dateFin' WHERE `projet`.`id` = '$id';";
            $sth = $connexion->dbco->prepare($requeteSql);
            $sth->execute();
            header("Location: list_projet_admin.php");
        }
    }
}