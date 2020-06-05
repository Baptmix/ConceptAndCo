<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$deleteProject = new gradeAdmin($dbco);
$deleteProject->deleteProject();

header("Location: list_projet_admin.php");