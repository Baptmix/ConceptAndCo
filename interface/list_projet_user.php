<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!DOCTYPE HTML>
<html>
<body>
<?php

session_start();

include "header_user.php";
include "../fonctionnalite/connexion.php";
include "../fonctionnalite/gradeUser.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$listProject = new gradeUser();
$listProject->list_project($dbco);

?>
</body>
</html>