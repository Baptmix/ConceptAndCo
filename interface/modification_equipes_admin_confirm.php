<?php

require_once('session_start.php');

include "header_admin.php";
include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$modificationEquipesConfirm = new gradeAdmin($dbco);
$modificationEquipesConfirm->modificationEquipesConfirm();