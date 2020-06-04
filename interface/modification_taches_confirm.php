<?php

session_start();

if ($_SESSION['id_privilege'] === '2') {
    include 'header_admin.php';
} else {
    include 'header_user.php';
}

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/noGrade.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$modificationTachesConfirm = new noGrade();
$modificationTachesConfirm->modificationTachesConfirm($dbco);