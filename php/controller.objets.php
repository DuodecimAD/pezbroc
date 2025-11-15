<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Objet.php';

use PEZBroc\User;
use PEZBroc\Objet;

$objet = new Objet();
$objets = $objet->getAllObjetsFromVisibleBrocanteurs();
$categories = $objet->getCategories();

$user = new User();
$users = $user->getAllUsersNotNullWithZones();

$noObjetBool = false;

$oCats = $_GET['oCats'] ?? [];

if (isset($_GET['resetCookie'])) {
    setcookie("search_options", "", time() - 3600);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_GET['cookie'])) {
    if (isset($_GET['search']) || isset($_GET['oCats']) || isset($_GET['brocanteursSelect'])) {
        $params = [];

        if (isset($_GET['search'])) {
            $params[] = 'search=' . urlencode($_GET['search']);
        }

        if (isset($_GET['oCats'])) {
            foreach ($_GET['oCats'] as $cat) {
                $params[] = 'oCats[]=' . urlencode($cat);
            }
        }

        if (isset($_GET['brocanteursSelect'])) {
            $params[] = 'brocanteursSelect=' . urlencode($_GET['brocanteursSelect']);
        }

        $inDays = 24 * 60 * 60;
        $inHours = 60 * 60;

        $addTime = 1 * $inHours;

        setcookie("search_options", '?' . implode('&', $params), time() + $addTime);
    }
}

if (!isset($_GET['search']) && !isset($_GET['oCats']) && !isset($_GET['brocanteursSelect']) && isset($_COOKIE["search_options"])) {
    $redirectUrl = $_SERVER['PHP_SELF'] . $_COOKIE['search_options'] . '&cookie';
    header("Location: " . $redirectUrl);
    exit;
}
