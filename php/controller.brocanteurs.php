<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Emplacement.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';

use PEZBroc\Emplacement;
use PEZBroc\User;

$usersObject = new User();
$emplacementObject = new Emplacement();

$zones = $emplacementObject->getZones();
$brocanteurs = $usersObject->getAllUsersNotNullWithZones();
