<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$deactivateEquipes = new gradeAdmin($dbco);
$deactivateEquipes->deactivateEquipes();

header("Location: list_equipes.php");