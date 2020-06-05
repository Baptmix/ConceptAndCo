<?php

include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeAdmin.php";

$deactivateAccount = new gradeAdmin($dbco);
$deactivateAccount->deactivateAccount();

header("Location: administration.php");