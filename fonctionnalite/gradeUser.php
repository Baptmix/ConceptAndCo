<?php

class gradeUser
{
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
              <th scope='col'>Date de fin</th>
              </tr>
        </thead>";
        foreach ($result as $row) {
            $nom_projet = $row['nom_projet'];
            $attribution = $row['attribution'];
            $date_debut = $row['date_debut'];
            $date_fin = $row['date_fin'];
            echo "<tbody><tr>
        <td>$nom_projet</td>
        <td>$attribution</td>
        <td>$date_debut</td>
        <td>$date_fin</td>
        </tr></tbody>";
        }
        echo "</table>";
    }
}