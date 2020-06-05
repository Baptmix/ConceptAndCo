<?php

session_start();

include "header_admin.php";
include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$modificationEquipesConfirm = new gradeAdmin($dbco);
$modificationEquipesConfirm->modificationEquipesConfirm();