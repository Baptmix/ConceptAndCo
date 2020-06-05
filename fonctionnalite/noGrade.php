<?php

/**
 * Class noGrade
 */
class noGrade
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * noGrade constructor.
     * @param connexion $connexion
     */
    public function __construct(connexion $connexion)
    {
        $this->connection = $connexion->dbco;
    }

    public function addTaches()
    {
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='add_taches.php' novalidate>
        <div class='form-row'>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Création de tâche</label>
            <input type='text' name='nom_tache' class='form-control' id='validationCustom01' placeholder='Nom de la tâche' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Description</label>
            <input type='text' name='description' class='form-control' id='validationCustom01' placeholder='Description' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label>Projet associé</label>";
        $requeteSql = "SELECT * FROM `projet`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<select class='custom-select' required name='projet_associe'>";
        foreach ($result as $row) {
            echo "<option>" . $row['nom_projet'] . "</option>";
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
        <button class='btn btn-primary' type='submit'>Ajouter la tâche</button>
        </form>
        </div>
        </center>";
        if (isset($_POST['nom_tache']) and $_POST['nom_tache'] !== '' and $_POST['nom_tache'] !== null) {
            $nom_tache = $_POST['nom_tache'];
            $description = $_POST['description'];
            $projet_associe = $_POST['projet_associe'];
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];
            $status = "en cours";
            $requeteSql = "INSERT INTO `taches` (`id`, `nom_tache`, `description`, `projet_associe`, `date_debut`, 
            `date_fin`, `status`) VALUES (NULL, '$nom_tache', '$description', '$projet_associe', '$date_debut', '$date_fin', '$status');";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
        }
    }

    public function deleteTaches()
    {
        $id = $_GET['id'];
        $requeteSQL = "DELETE FROM `taches` WHERE `id`= '$id';";
        $sth = $this->connection->prepare($requeteSQL);
        $sth->execute();
    }

    public function modificationTachesConfirm()
    {
        $id = $_GET['id'];
        if (isset($_POST['nom_tache'])
            and $_POST['nom_tache'] !== ''
            and $_POST['nom_tache'] !== null) {
            $nom_tache = $_POST['nom_tache'];
            $description = $_POST['description'];
            $projet_associe = $_POST['projet_associe'];
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];
            $requeteSql = "UPDATE `taches` SET `nom_tache` = '$nom_tache', `description` = '$description', 
            `projet_associe` = '$projet_associe', `date_debut` = '$date_debut', `date_fin` = '$date_fin' WHERE `taches`.`id` = '$id';";
            $sth = $this->connection->prepare($requeteSql);
            $sth->execute();
            header("Location: list_taches.php");
        }
    }

    public function modificationTaches()
    {
        $id = $_GET['id'];
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='modification_taches_confirm.php?id=$id' novalidate>";
        $nom_tache = $_GET['nom_tache'];
        echo "<div class='form-row'>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Nom de la tâche</label>
            <input type='text' name='nom_tache' class='form-control' id='validationCustom01' value='$nom_tache'>
        </div>";
        $description = $_GET['description'];
        echo "<div class='form-row'>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Description</label>
            <input type='text' name='description' class='form-control' id='validationCustom01' value='$description'>
        </div>";
        $requeteSql = "SELECT * FROM `projet`";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<div class='col-md-6 mb-3'>
        <label for='validationCustom01'>Projet assoccié</label>
        <select class='custom-select' name='projet_associe'>";
        foreach ($result as $row) {
            $projet_associe = $_GET['projet_associe'];
            echo "<option value='$projet_associe'>" . $row['nom_projet'] . "</option>";
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
        echo "<button class='btn btn-success' type='submit'>Modifier la tâche</button>";
        echo '</form></center>';
    }

    public function listTaches()
    {
        $login = $_SESSION['login'];
        $requeteSql = "SELECT `id`, `nom_tache`, `description`, `projet_associe`, `date_debut`, `date_fin`, `status` 
        FROM `taches` WHERE `projet_associe` IN (SELECT `nom_projet` FROM `projet` WHERE `attribution` = '$login')";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        echo "<center><div style='max-width: 97%;'>
        <table class='table table-hover'>
        <thead>
          <tr>
              <th scope='col'>Nom de la tâche</th>
              <th scope='col'>Description</th>
              <th scope='col'>Projet associé</th>
              <th scope='col'>Date de début</th>
              <th scope='col'>Date de fin</th>
              <th scope='col'></th>
              <th scope='col'></th>
              </tr>
        </thead>";
        foreach ($result as $row) {
            $nom_tache = $row['nom_tache'];
            $description = $row['description'];
            $projet_associe = $row['projet_associe'];
            $date_debut = $row['date_debut'];
            $date_fin = $row['date_fin'];
            $id = $row['id'];
            echo "<tbody>
             <tr>
            <td>$nom_tache</td>
            <td>$description</td>
            <td>$projet_associe</td>
            <td>$date_debut</td>
            <td>$date_fin</td>
            <td>";
            echo "<a href='modification_taches.php?nom_tache=$nom_tache&description=$description&projet_associe=$projet_associe&date_debut=$date_debut&date_fin=$date_fin&id=$id'>
                        <button type='button' class='btn btn-warning'>Modifier</button></a>";
            echo "</td><td>";
            echo "<a href='delete_taches.php?id=$id'><button type='button' class='btn btn-danger'>Supprimer</button></a>
            </td>
            </tr>
            </tbody>";
        }
        echo "</table></div></center>";
    }

    public function modificationPassword()
    {
        echo "<center><div style='max-width: 97%;'>
        <form class='needs-validation' method='post' action='modification_password.php' novalidate>
        <div class='form-row'>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Nouveau</label>
            <input type='password' name='newmdp' class='form-control' id='validationCustom01' placeholder='Nouveau mot de passe' required>
        </div>
        <div class='col-md-6 mb-3'>
            <label for='validationCustom01'>Confirmer</label>
            <input type='password' name='confirmmdp' class='form-control' id='validationCustom01' placeholder='Confirmer le mot de passe' required>
        </div>
        </div>
        <button class='btn btn-success' type='submit'>Valider</button>
        </form></div></center>";
        if ((isset($_POST['newmdp'])) and (isset($_POST['confirmmdp']))) {
            if ($_POST['newmdp'] === $_POST['confirmmdp']) {
                if (($_POST['newmdp'] !== '') or !empty($_POST['newmdp'] !== '')) {
                    $newmdp = $_POST['newmdp'];
                    $id = $_SESSION['id'];
                    $requeteSql = "UPDATE `account` SET `password` = '$newmdp' WHERE `account`.`id` = '$id';";
                    $sth = $this->connection->prepare($requeteSql);
                    $sth->execute();
                    header("Location: logout.php");
                }
            }
        }
    }

    public function profile()
    {
        $login = $_SESSION['login'];
        $password = $_SESSION['password'];
        echo "<center><div style='max-width: 97%;'>
        <table class='table table-hover'>
        <tr>
            <th scope='col'>Nom d'utilisateur</th>
            <td>$login</td>
            <td></td>
        </tr>
        <tr>
            <th scope='col'>Mot de passe</th>
            <td>$password</td>
            <td><a href='modification_password.php'><button type='button' class='btn btn-warning'>Modifier</button></a></td>
        </tr>
        <tr>
            <th scope='col'>Mon équipe</th>
            <td>";
        $requeteSql = "SELECT `id_equipes` FROM `account` WHERE `account`.`login` = '$login' AND `account`.`password` = '$password' LIMIT 1";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $selection = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $id_equipes = $selection[0]['id_equipes'];
        $requeteSql = "SELECT `nom` FROM `equipes` WHERE `equipes`.`id` = '$id_equipes' LIMIT 1";
        $sth = $this->connection->prepare($requeteSql);
        $sth->execute();
        $selection = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $mon_equipe = $selection[0]['nom'];
        echo $mon_equipe;
        echo "</td>
            <td></td>
        </tr>
        <tr>
        <th scope='col'>Grade du compte</th>
        <td>";
        if (isset($_SESSION['id_privilege'])) {
            if ($_SESSION['id_privilege'] === '1') {
                echo "user";
            } elseif ($_SESSION['id_privilege'] === '2') {
                echo "administrator";
            }
        }
        echo "</td>
        <td></td>
        </tr>
        </table>
        </div> 
        </center>";
    }

    public function login()
    {
        echo "<form method='post' action='index.php'>
        <center><br><div class='align-items-center'>
            <div class='col-sm-3 my-1'>
                <div class='input-group'>
                    <div class='input-group-prepend'>
                        <div class='input-group-text'>
                            <svg class='bi bi-person-fill' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor'
                                 xmlns='http://www.w3.org/2000/svg'>
                                <path fill-rule='evenodd'
                                      d='M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 100-6 3 3 0 000 6z'
                                      clip-rule='evenodd'/>
                            </svg>
                        </div>
                    </div>
                    <input type='email' name='login' class='form-control' placeholder='Email'>
                </div>
            </div>
            <div class='col-sm-3 my-1'>
                <div class='input-group'>
                    <div class='input-group-prepend'>
                        <div class='input-group-text'>
                            <svg class='bi bi-backspace-reverse-fill' width='1em' height='1em' viewBox='0 0 16 16'
                                 fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                <path fill-rule='evenodd'
                                      d='M0 3a2 2 0 012-2h7.08a2 2 0 011.519.698l4.843 5.651a1 1 0 010 1.302L10.6 14.3a2 2 0 01-1.52.7H2a2 2 0 01-2-2V3zm9.854 2.854a.5.5 0 00-.708-.708L7 7.293 4.854 5.146a.5.5 0 10-.708.708L6.293 8l-2.147 2.146a.5.5 0 00.708.708L7 8.707l2.146 2.147a.5.5 0 00.708-.708L7.707 8l2.147-2.146z'
                                      clip-rule='evenodd'/>
                            </svg>
                        </div>
                    </div>
                    <input type='password' class='form-control' id='inlineFormInputGroupUsername'
                           placeholder='Mot de passe' name='password'>
                </div>
            </div><br>
            <div class='col-auto my-1'>
                <button type='submit' class='btn btn-primary'>Connexion</button>
            </div>
        </div></center>
        </form>";
        if (isset($_POST['login']) and isset($_POST['password'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $req = $this->connection->prepare("SELECT * FROM `account` WHERE `login`='$login' AND `password`='$password';");
            $req->execute(array(
                'login' => $login,
                'password' => $password));
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            foreach ($result as $index => $row) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['id_privilege'] = $row['id_privilege'];
            }
            if ($result) {
                if ($_SESSION['id_privilege'] === '1') {
                    header("Location: interface/list_projet_user.php");
                } elseif ($_SESSION['id_privilege'] === '2') {
                    header("Location: interface/list_projet_admin.php");
                }
            }
        }
    }
}