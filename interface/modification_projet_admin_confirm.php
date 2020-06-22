<?php

require_once('session_start.php');

if ($_SESSION['id_privilege'] === '2') {
    include 'header_admin.php';
} else {
    include 'header_user.php';
}

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$modificationProjectConfirm = new gradeAdmin($dbco);
$modificationProjectConfirm->modificationProjectConfirm();