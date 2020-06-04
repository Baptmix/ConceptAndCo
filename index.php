<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>CONCEPT & CO | Login</title>
</head>
<body>
<center>
    <img src="img/conceptco.PNG" class="img-fluid" alt="Responsive image">
</center>
<?php

session_start();

include "fonctionnalite/connexion.php";
include "fonctionnalite/noGrade.php";

$dbco = new connexion("localhost", "ppedev", "root", "");
$login = new noGrade();
$login->login($dbco);

?>
</body>
</html>

