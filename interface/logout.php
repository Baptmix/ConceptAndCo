<?php

require_once('session_start.php');
session_destroy();
session_unset();

header("Location: ../index.php");