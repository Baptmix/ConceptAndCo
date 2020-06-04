<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/noGrade.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$deleteTaches = new noGrade();
$deleteTaches->deleteTaches($dbco);

header("Location: list_taches.php");