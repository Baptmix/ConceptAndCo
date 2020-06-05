<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/noGrade.php";

$deleteTaches = new noGrade($dbco);
$deleteTaches->deleteTaches();

header("Location: list_taches.php");