<?php
session_start();
require_once(__DIR__ . '/../configuration/mysql.php');
require_once(__DIR__ . '/../configuration/databaseconnect.php');
require_once(__DIR__ . '/../variables/functions.php');
require_once(__DIR__ . '/../variables/variables.php');

if (!empty($_GET)) {
    deleteRecette($_GET, $mysqlClient);
    redirectToUrl("../home.php");
} else {
    redirectToUrl("../home.php");
}

