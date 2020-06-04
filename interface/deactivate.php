<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$deactivate = new gradeAdmin();
$deactivate->deactivate($dbco);

header("Location: administration.php");