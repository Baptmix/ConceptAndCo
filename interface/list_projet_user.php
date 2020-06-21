<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!DOCTYPE HTML>
<html>
<body>
<?php

require_once('session_start.php');

if ($_SESSION['langage'] === 'fr') {
    require_once('../traduction/traduction_fr.php');
} else {
    require_once('../traduction/traduction_en.php');
}

include "header_user.php";
include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeUser.php";

$listProject = new gradeUser($dbco);
$listProject->listProject($traduction);

?>
</body>
</html>