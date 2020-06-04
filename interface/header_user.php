<head>
    <meta charset="utf-8">
    <title>CONCEPT & CO</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "list_projet_user") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="list_projet_user.php">Consulter les projets<span class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "list_taches") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="list_taches.php">Consulter les tâches<span class="sr-only">(current)</span></a>
            </li>

            <?php
            $nomDeLaPageEnCours = basename($_SERVER['REQUEST_URI'], ".php");
            if ($nomDeLaPageEnCours === "add_taches") {
                echo '<li class="nav-item active">';
            } else {
                echo '<li class="nav-item ">';
            }
            ?>
            <a class="nav-link" href="add_taches.php">Ajouter des tâches<span
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
            <a class="nav-link" href="profile.php">Profil<span
                        class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
    <a href="logout.php">
        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Déconnexion</button>
    </a>
</nav>
<br><br>