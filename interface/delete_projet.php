<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$deleteProject = new gradeAdmin();
$deleteProject->deleteProject($dbco);

header("Location: list_projet_admin.php");