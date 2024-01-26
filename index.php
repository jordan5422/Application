<?php
session_start();
require_once(__DIR__ . '/configuration/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
redirectToUrl('login/login.php');