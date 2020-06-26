<?php

/**
 * Class gradeAdmin
 */
class gradeAdmin
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * gradeAdmin constructor.
     * @param connexion $connexion
     */
    public function __construct(connexion $connexion)
    {
        $this->connection = $connexion->dbco;
    }

    public function createEquipes($traduction)
    {
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='create_equipes.php' novalidate>
        <div class='form-group row'>
        <label for='inputPassword' class='col-sm-2 col-form-label'>" . $traduction['CREATE_EQUIPES']['LABEL_NOM_EQUIPE'] . "</label>
            <div class='col-sm-10'>
            <input type='text' name='nom' class='form-control' id='inputPassword' placeholder='" . $traduction['CREATE_EQUIPES']['PLACEHOLDER_NOM_EQUIPE'] . "' required>
            </div></div>        
        <br><h4>" . $traduction['CREATE_EQUIPES']['TITLE_AJOUTER_UTILISATEURS'] . "</h4><br>";
        $requeteSql = "SELECT * FROM `account`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<ul class='list-group'>";
        foreach ($result as $row) {
            $login = $row['login'];
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>$login
            <span><input type='checkbox' name='checkbox[]' value='$login'></span>
            </li>";
        }
        echo "</ul></div>";
        if ($_SESSION['is_handicapped'] == 'non') {
            echo "<br><br><button class='btn btn-primary' type='submit'>" . $traduction['CREATE_EQUIPES']['BOUTON_AJOUTER_EQUIPE'] . "</button>";
        } else {
            echo "<br><br><button class='btn btn-secondary' type='submit'>" . $traduction['CREATE_EQUIPES']['BOUTON_AJOUTER_EQUIPE'] . "</button>";
        }
        echo "</form></div></center>";
        if (isset($_POST['nom']) and $_POST['nom'] !== '' and $_POST['nom'] !== null) {
            $nom = $_POST['nom'];
            $requeteSql = "INSERT INTO `equipes` (`id`, `nom`, `deactivate`) VALUES (NULL, '$nom', 'non');";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            $account = $_POST['checkbox'];
            $requeteSql = "SELECT `id` FROM `equipes` WHERE `nom` = '$nom' LIMIT 1";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $id_equipes = $result[0]['id'];
            foreach ($account as $row) {
                $requeteSql = "UPDATE `account` SET `id_equipes` = '$id_equipes' WHERE `account`.`login` = '$row';";
                $sth = $this->connection->prepare($requeteSql);
                $sth->execute();
            }
        }
    }

    public function modificationEquipesConfirm()
    {
        $id = $_GET['id'];
        if (isset($_POST['nom_equipe'])
            and $_POST['nom_equipe'] !== ''
            and $_POST['nom_equipe'] !== null) {
            $nom_equipe = $_POST['nom_equipe'];
            $requeteSql = "UPDATE `equipes` SET `nom` = '$nom_equipe' WHERE `equipes`.`id` = '$id';";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            header("Location: list_equipes.php");
        }
    }


    public function modificationEquipes($traduction)
    {
        $id = $_GET['id'];
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='modification_equipes_admin_confirm.php?id=$id' novalidate>";
        $nom_equipe = $_GET['nom_equipe'];
        echo "<div class='form-row'><div class='col-md-6 mb-3'>
        <label for='validationCustom01'>" . $traduction['MODIFICATION_EQUIPE']['LABEL_NOM_EQUIPE'] . "</label>
        <input type='text' name='nom_equipe' class='form-control' id='validationCustom01' value='$nom_equipe'></div></div>";
        if ($_SESSION['is_handicapped'] == 'non') {
            echo "<button class='btn btn-success' type='submit'>" . $traduction['MODIFICATION_EQUIPE']['BOUTON_MODIFIER_CONFIRM'] . "</button>";
        } else {
            echo "<button class='btn btn-secondary' type='submit'>" . $traduction['MODIFICATION_EQUIPE']['BOUTON_MODIFIER_CONFIRM'] . "</button>";
        }
        echo "</form></center>";
    }


    public function listEquipes($traduction)
    {
        $requeteSql = "SELECT `id`, `nom` FROM `equipes` WHERE `deactivate` <> 'oui'";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<center><div style='max-width: 97%;'><table class='table table-hover'><thead>
                    <tr>
                        <th scope='col'>" . $traduction['LIST_EQUIPES']['TABLEAU_LIST_EQUIPES_NOM'] . "</th>
                        <th scope='col'>" . $traduction['LIST_EQUIPES']['TABLEAU_LIST_EQUIPES_MEMBRES'] . "</th>
                        <th scope='col'></th>
                        <th scope='col'></th>
                    </tr>
                    </thead>";
        foreach ($result as $row) {
            $nom_equipe = $row['nom'];
            echo "<tbody>
             <tr>
            <td>$nom_equipe</td>
            <td>";
            $requeteSql = "SELECT `id` FROM `equipes` WHERE `equipes`.`nom` = '$nom_equipe'";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $id_equipes = $result[0]['id'];
            $requeteSql = "SELECT COUNT(`id_equipes`) AS `count` FROM `account` WHERE `account`.`id_equipes` = '$id_equipes'";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $count = $result[0]['count'];
            echo $count;
            echo "</td>
            <td>";
            $id = $row['id'];
            if ($_SESSION['is_handicapped'] == 'non') {
                echo "<a href='modification_equipes_admin.php?nom_equipe=$nom_equipe&id=$id'>
                            <button type='button' class='btn btn-warning'>" . $traduction['LIST_EQUIPES']['BOUTON_MODIFIER'] . "</button></a>";
            } else {
                echo "<a href='modification_equipes_admin.php?nom_equipe=$nom_equipe&id=$id'>
                            <button type='button' class='btn btn-secondary'>" . $traduction['LIST_EQUIPES']['BOUTON_MODIFIER'] . "</button></a>";
            }
            echo "</td><td>";
            if ($_SESSION['is_handicapped'] == 'non') {
                echo "<a href='deactivate_equipes.php?id=$id'>
                            <button type='button' class='btn btn-danger'>" . $traduction['LIST_EQUIPES']['BOUTON_DESACTIVER'] . "</button></a>";
            } else {
                echo "<a href='deactivate_equipes.php?id=$id'>
                            <button type='button' class='btn btn-dark'>" . $traduction['LIST_EQUIPES']['BOUTON_DESACTIVER'] . "</button></a>";
            }
            echo "</td></tr></tbody>";
        }
        echo "</table></div></center>";
    }

    public function deactivateAccount()
    {
        $id = $_GET['id'];
        $requeteSQL = "UPDATE `account` SET `deactivate` = 'oui' WHERE `account`.`id` = $id;";
        $sth = $this->connection->prepare($requeteSQL);
        $sth->execute();
    }

    public function deactivateEquipes()
    {
        $id = $_GET['id'];
        $requeteSQL = "UPDATE `equipes` SET `deactivate` = 'oui' WHERE `equipes`.`id` = $id;";
        $sth = $this->connection->prepare($requeteSQL);
        $sth->execute();
    }

    public function administration($traduction)
    {
        $requeteSql = "SELECT `id`, `nom`, `prenom`, `login`, `password`, `id_privilege`, `is_handicapped`, `deactivate` 
        FROM `account` WHERE `id_privilege` <> '2' AND `deactivate` <> 'oui'";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<center><div style='max-width: 97%;'><table class='table table-hover'><thead>
                    <tr>
                        <th scope='col'>" . $traduction['ADMINISTRATION']['TABLEAU_ADMINISTRATION_NOM'] . "</th>
                        <th scope='col'>" . $traduction['ADMINISTRATION']['TABLEAU_ADMINISTRATION_PRENOM'] . "</th>
                        <th scope='col'>" . $traduction['ADMINISTRATION']['TABLEAU_ADMINISTRATION_EMAIL'] . "</th>
                        <th scope='col'>" . $traduction['ADMINISTRATION']['TABLEAU_ADMINISTRATION_UTILISATEURS'] . "</th>
                    </tr></thead>";
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
            if ($_SESSION['is_handicapped'] == 'non') {
                echo "<a href='deactivate_account.php?id=$id'>
                            <button type='button' class='btn btn-warning'>" . $traduction['ADMINISTRATION']['BOUTON_DESACTIVER'] . "</button></a>";
            } else {
                echo "<a href='deactivate_account.php?id=$id'>
                            <button type='button' class='btn btn-secondary'>" . $traduction['ADMINISTRATION']['BOUTON_DESACTIVER'] . "</button></a>";
            }
            echo "</td></tr></tbody>";
        }
        echo "</table></div></center>";
    }

    public function createUser($traduction)
    {
        echo "<center><div style='max-width: 97%;'><form class='needs-validation' method='post' action='create_user_admin.php' novalidate>
        <div class='form-row'><div class='col-md-6 mb-3'><label for='validationCustom01'>" . $traduction['CREATE_USER']['NOM'] . "</label>
        <input type='text' name='nom' class='form-control' id='validationCustom01' placeholder='" . $traduction['CREATE_USER']['NOM'] . "' required>
        </div><div class='col-md-6 mb-3'><label for='validationCustom01'>" . $traduction['CREATE_USER']['PRENOM'] . "</label>
        <input type='text' name='prenom' class='form-control' id='validationCustom01' placeholder='" . $traduction['CREATE_USER']['PRENOM'] . "' required>
        </div><div class='col-md-6 mb-3'><label for='validationCustom01'>" . $traduction['CREATE_USER']['EMAIL'] . "</label>
        <input type='email' name='login' class='form-control' id='validationCustom01' placeholder='" . $traduction['CREATE_USER']['EMAIL'] . "' required>
        </div><div class='col-md-6 mb-3'><label for='validationCustom01'>" . $traduction['CREATE_USER']['MOT_DE_PASSE'] . "</label>
        <input type='password' name='password' class='form-control' placeholder='" . $traduction['CREATE_USER']['MOT_DE_PASSE'] . "' required>
        </div><div class='col-md-6 mb-3'><label>" . $traduction['CREATE_USER']['EQUIPE'] . "</label>";
        $requeteSql = "SELECT * FROM `equipes`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<select class='custom-select' name='id_equipes' required>";
        foreach ($result as $row) {
            echo "<option>" . utf8_encode($row['nom']) . "</option>";
        }
        echo "</select></div><div class='col-md-6 mb-3'><label>" . $traduction['CREATE_USER']['GRADE'] . "</label>";
        $requeteSql = "SELECT * FROM `privilege`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<select class='custom-select' name='id_privilege' required>";
        foreach ($result as $row) {
            echo "<option>" . utf8_encode($row['wording']) . "</option>";
        }
        echo "</select></div></div><hr><p>" . $traduction['CREATE_USER']['LABEL_HANDICAP'] . "</p>
        <input type='radio' name='radio' value='oui'>" . $traduction['CREATE_USER']['RADIO_OUI'] . "&nbsp;&nbsp;&nbsp;
        <input type='radio' name='radio' value='non'>" . $traduction['CREATE_USER']['RADIO_NON'] . "
        <br><br><hr><p>" . $traduction['CREATE_USER']['LABEL_LANGAGE'] . "</p>
        <input type='radio' name='radio2' value='fr'>" . $traduction['CREATE_USER']['RADIO_FR'] . "&nbsp;&nbsp;&nbsp;
        <input type='radio' name='radio2' value='en'>" . $traduction['CREATE_USER']['RADIO_EN'] . "";
        if ($_SESSION['is_handicapped'] == 'non') {
            echo "<br><br><button class='btn btn-primary' type='submit'>" . $traduction['CREATE_USER']['BOUTON_AJOUTER_UTILISATEUR'] . "</button>";
        } else {
            echo "<br><br><button class='btn btn-secondary' type='submit'>" . $traduction['CREATE_USER']['BOUTON_AJOUTER_UTILISATEUR'] . "</button>";
        }
        echo "</form></div></center>";
        if (isset($_POST['login']) and $_POST['login'] !== '' and $_POST['login'] !== null) {
            $login = $_POST['login'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $password = $_POST['password'];
            $idEquipes = utf8_encode($_POST['id_equipes']);
            $requeteSql = "SELECT `id` FROM `equipes` WHERE `equipes`.`nom` = '$idEquipes' LIMIT 1";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $idEquipes = $result[0]['id'];
            $idPrivilege = $_POST['id_privilege'];
            $requeteSql = "SELECT `id` FROM `privilege` WHERE `privilege`.`wording` = '$idPrivilege'";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            if (isset($result[0]['id'])) {
                $idPrivilege = $result[0]['id'];
            } else {
                $idPrivilege = '1';
            }

            if ($_POST['radio'] == 'oui') {
                $isHandicapped = 'oui';
            } elseif ($_POST['radio'] == 'non') {
                $isHandicapped = 'non';
            }

            if ($_POST['radio2'] == 'fr') {
                $langage = 'fr';
            } elseif ($_POST['radio2'] == 'en') {
                $langage = 'en';
            }

            $requeteSql = "INSERT INTO `account` (`id`, `nom`, `prenom`, `login`, `password`, `id_privilege`, `is_handicapped`, 
            `id_equipes`, `langage`, `deactivate`) VALUES (NULL, '$nom', '$prenom', '$login', '$password', '$idPrivilege', 
            '$isHandicapped', '$idEquipes', '$langage','non');";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
        }
    }

    public function addProject($traduction)
    {
        echo "<center><div style='max-width: 97%;'><form class='needs-validation' method='post' action='add_projet_admin.php' novalidate>
        <div class='form-row'><div class='col-md-6 mb-3'>
        <label for='validationCustom01'>" . $traduction['ADD_PROJECT']['LABEL_CREATION_PROJET'] . "</label>
        <input type='text' name='nom_projet' class='form-control' id='validationCustom01' placeholder='" . $traduction['ADD_PROJECT']['PLACEHOLDER_NOM_PROJET'] . "' required>
        </div><div class='col-md-6 mb-3'>
        <label>" . $traduction['ADD_PROJECT']['LABEL_ATTRIBUTION'] . "</label>";
        $requeteSql = "SELECT * FROM `account`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<select class='custom-select' required name='attribution'>";
        foreach ($result as $row) {
            echo "<option>" . $row['login'] . "</option>";
        }
        echo "</select></div><div class='col-md-6 mb-3'>
            <label for='validationCustom01'>" . $traduction['ADD_PROJECT']['LABEL_DATE_DEBUT'] . "</label>
            <input type='date' name='date_debut' class='form-control' required>
        </div><div class='col-md-6 mb-3'>
            <label for='validationCustom01'>" . $traduction['ADD_PROJECT']['LABEL_DATE_FIN'] . "</label>
            <input type='date' name='date_fin' class='form-control' required>
        </div></div>";
        if ($_SESSION['is_handicapped'] == 'non') {
            echo "<button class='btn btn-primary' type='submit'>" . $traduction['ADD_PROJECT']['BOUTON_AJOUTER_PROJET'] . "</button>";
        } else {
            echo "<button class='btn btn-secondary' type='submit'>" . $traduction['ADD_PROJECT']['BOUTON_AJOUTER_PROJET'] . "</button>";

        }
        echo "</form></div></center>";
        if (isset($_POST['nom_projet']) and $_POST['nom_projet'] !== '' and $_POST['nom_projet'] !== null) {
            $nomProjet = $_POST['nom_projet'];
            $attribution = $_POST['attribution'];
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];
            $requeteSql = "INSERT INTO `projet` (`id`, `nom_projet`, `attribution`, `date_debut`, `date_fin`)
            VALUES (NULL, '$nomProjet', '$attribution', '$dateDebut', '$dateFin');";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
        }
    }

    public function deleteProject()
    {
        $id = $_GET['id'];
        $requeteSQL = "DELETE FROM `projet` WHERE `id`= '$id';";
        $sth = $this->connection->prepare($requeteSQL);
        $sth->execute();
    }

    public function listProject($traduction)
    {
        $login = $_SESSION['login'];
        $requeteSql = "SELECT `id`, `nom_projet`, `attribution`, `date_debut`, `date_fin` FROM `projet` WHERE `attribution` = '$login';";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<center><div style='max-width: 97%;'><table class='table table-hover'><thead>
                    <tr>
                        <th scope='col'>" . $traduction['LIST_PROJET']['TABLEAU_PROJET_NOM'] . "</th>
                        <th scope='col'>" . $traduction['LIST_PROJET']['TABLEAU_PROJET_ATTRIBUTION'] . "</th>
                        <th scope='col'>" . $traduction['LIST_PROJET']['TABLEAU_PROJET_DATE_DEBUT'] . "</th>
                        <th scope='col'>" . $traduction['LIST_PROJET']['TABLEAU_PROJET_PROGRESSION'] . "</th>
                        <th scope='col'>" . $traduction['LIST_PROJET']['TABLEAU_PROJET_DATE_FIN'] . "</th>
                        <th scope='col'></th>
                        <th scope='col'></th>
                    </tr></thead>";
        foreach ($result as $row) {
            $nom_projet = $row['nom_projet'];
            $attribution = $row['attribution'];
            $date_debut = $row['date_debut'];
            $date_fin = $row['date_fin'];
            $dateFin = $rest = substr($date_fin, 0, -9);
            $dateDebut = $rest = substr($date_debut, 0, -9);
            $width = 60;
            if ($dateFin == date('Y-m-d')) {
                $width = 100;
            } elseif ($dateDebut == date('Y-m-d')) {
                $width = 10;
            }
            if ($_SESSION['is_handicapped'] == 'non') {
                $progression = "<div class='progress'>
                <div class='progress-bar-animated progress-bar-striped bg-success' role='progressbar' style='width: $width%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                </div>";
            } else {
                $progression = "<div class='progress'>
                <div class='progress-bar-animated progress-bar-striped bg-secondary' role='progressbar' style='width: $width%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                </div>";
            }
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
            if ($_SESSION['is_handicapped'] == 'non') {
                echo "<a href='modification_projet_admin.php?nom_projet=$nom_projet&attribution=$attribution&date_debut=$date_debut&date_fin=$date_fin&id=$id'>
                            <button type='button' class='btn btn-warning'>" . $traduction['LIST_PROJET']['BOUTON_MODIFIER'] . "</button></a>";
            } else {
                echo "<a href='modification_projet_admin.php?nom_projet=$nom_projet&attribution=$attribution&date_debut=$date_debut&date_fin=$date_fin&id=$id'>
                            <button type='button' class='btn btn-secondary'>" . $traduction['LIST_PROJET']['BOUTON_MODIFIER'] . "</button></a>";
            }
            echo "</td><td>";
            if ($_SESSION['is_handicapped'] == 'non') {
                echo "<a href='delete_projet.php?id=$id'>
                            <button type='button' class='btn btn-danger'>" . $traduction['LIST_PROJET']['BOUTON_SUPPRIMER'] . "</button></a>";
            } else {
                echo "<a href='delete_projet.php?id=$id'>
                            <button type='button' class='btn btn-dark'>" . $traduction['LIST_PROJET']['BOUTON_SUPPRIMER'] . "</button></a>";
            }
            echo "</td></tr></tbody>";
        }
        echo "</table></div></center>";
    }

    public function modificationProject($traduction)
    {
        $id = $_GET['id'];
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='modification_projet_admin_confirm.php?id=$id' novalidate>";
        $nom_projet = $_GET['nom_projet'];
        echo "<div class='form-row'><div class='col-md-6 mb-3'>
        <label for='validationCustom01'>" . $traduction['MODIFICATION_PROJET']['LABEL_NOM_PROJET'] . "</label>
        <input type='text' name='nom_projet' class='form-control' id='validationCustom01' value='$nom_projet'></div>";
        $requeteSql = "SELECT * FROM `account`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>" . $traduction['MODIFICATION_PROJET']['LABEL_ATTRIBUTION'] . "</label>
        <select class='custom-select' name='attribution'>";
        foreach ($result as $row) {
            $attribution = $_GET['attribution'];
            echo "<option value='$attribution'>" . $row['login'] . "</option>";
        }
        echo "</select></div>";
        $date_debut = $_GET['date_debut'];
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>" . $traduction['MODIFICATION_PROJET']['LABEL_DATE_DEBUT'] . "</label>
        <input type='text' name='date_debut' class='form-control' id='validationCustom01' value='$date_debut'></div>";
        $date_fin = $_GET['date_fin'];
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>" . $traduction['MODIFICATION_PROJET']['LABEL_DATE_FIN'] . "</label>
        <input type='text' name='date_fin' class='form-control' id='validationCustom01' value='$date_fin'></div></div>";
        if ($_SESSION['is_handicapped'] == 'non') {
            echo "<button class='btn btn-success' type='submit'>" . $traduction['MODIFICATION_PROJET']['BOUTON_MODIFIER_CONFIRM'] . "</button>";
        } else {
            echo "<button class='btn btn-secondary' type='submit'>" . $traduction['MODIFICATION_PROJET']['BOUTON_MODIFIER_CONFIRM'] . "</button>";
        }
        echo "</form></center>";
    }

    public function modificationProjectConfirm()
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
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            header("Location: list_projet_admin.php");
        }
    }
}