<?php
session_start();
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/configuration/databaseconnect.php');
require_once(__DIR__ . '/variables/variables.php');
require_once(__DIR__ . '/variables/functions.php');
redirectToUrl('login/login.php');