<?php

session_start();

include "header_admin.php";
include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$modificationProjectConfirm = new gradeAdmin();
$modificationProjectConfirm->modificationProjectConfirm($dbco);