<?php

session_start();

if ($_SESSION['id_privilege'] === '2') {
    include 'header_admin.php';
} else {
    include 'header_user.php';
}

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/noGrade.php";

$modificationTachesConfirm = new noGrade($dbco);
$modificationTachesConfirm->modificationTachesConfirm();