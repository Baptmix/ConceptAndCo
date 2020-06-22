<?php

require_once('session_start.php');

if ($_SESSION['langage'] === 'fr') {
    require_once('../traduction/traduction_fr.php');
} else {
    require_once('../traduction/traduction_en.php');
}

?>

<head>
    <meta charset="utf-8">
    <title>CONCEPT & CO</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "list_projet_admin") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link"
               href="list_projet_admin.php"><?php echo $traduction['HEADER']['PAGE_CONSULTER_PROJETS'] ?><span
                        class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "add_projet_admin") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="add_projet_admin.php"><?php echo $traduction['HEADER']['PAGE_AJOUTER_PROJETS'] ?>
                <span
                        class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "list_taches") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="list_taches.php"><?php echo $traduction['HEADER']['PAGE_CONSULTER_TACHES'] ?><span
                        class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "add_taches") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="add_taches.php"><?php echo $traduction['HEADER']['PAGE_AJOUTER_TACHES'] ?><span
                        class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "create_user_admin") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link"
               href="create_user_admin.php"><?php echo $traduction['HEADER']['PAGE_CREER_UTILISATEUR'] ?><span
                        class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "administration") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="administration.php"><?php echo $traduction['HEADER']['PAGE_ADMINISTRATION'] ?>
                <span class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "list_equipes") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="list_equipes.php"><?php echo $traduction['HEADER']['PAGE_CONSULTER_EQUIPES'] ?>
                <span class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "create_equipes") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="create_equipes.php"><?php echo $traduction['HEADER']['PAGE_CREER_EQUIPE'] ?><span
                        class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "profile" or $nomDeLaPageEnCours === "modification_password") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="profile.php"><?php echo $traduction['HEADER']['PAGE_PROFIL'] ?><span
                        class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
    <?php

    if ($_SESSION['is_handicapped'] == 'oui'){
        echo "<a href='logout.php'>
        <button class='btn btn-outline-light my-2 my-sm-0' type='submit'>" . $traduction['HEADER']['BOUTON_DECONNEXION'] . "</button></a>";
    } else {
        echo "<a href='logout.php'>
        <button class='btn btn-outline-danger my-2 my-sm-0' type='submit'>" . $traduction['HEADER']['BOUTON_DECONNEXION'] . "</button></a>";
    }

    ?>
</nav>
<br><br>