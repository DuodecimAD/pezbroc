<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

if (!isset($_SESSION['user']['loggedIn']) || $_SESSION['user']['est_administrateur'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Emplacement.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';

use PEZBroc\Emplacement;
use PEZBroc\User;

$usersObject = new User();
$emplacementObject = new Emplacement();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["reloadDeleted"])) {
    echo "test";
    cancelAllDeleted();
    header("location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit_delete"])) {
    $bid = filter_var(nettoyage_to_db($_POST['idToDelete']), FILTER_VALIDATE_INT) ?? '';
    $deleteResult = $usersObject->deleteUserAndObjets($bid);

    $username = nettoyage_to_db($_POST['username']) ?? '';

    if($deleteResult === "success"){
        $redirectUrl = $_SERVER['PHP_SELF'] . '?success=del' . '&username=' . urlencode($username);

        if(isset($_POST['hadEmplacement'])){
            $redirectUrl .= '&hadEmplacement';
        }

        header("Location: " . $redirectUrl);
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["modif"])) {
    $newCode = nettoyage_to_db($_POST['emplacements']) ?? '';
    $bid = filter_var(nettoyage_to_db($_POST['userId']), FILTER_VALIDATE_INT) ?? null;

    if ($newCode === 'removeEmplacement'){
        $updateResult = $usersObject->removeEmplacement($bid);
    } else {
        $updateResult = $usersObject->updateUserEmplacement($bid, $newCode);
    }


    $oldCode = nettoyage_to_db($_POST['currentCode']) ?? '';
    $username = nettoyage_to_db($_POST['username']) ?? '';

    if($updateResult){
        $redirectUrl = $_SERVER['PHP_SELF'];
        if($oldCode === ''){
            $redirectUrl .= '?success=ajout';
        } elseif($newCode === 'removeEmplacement'){
            $redirectUrl .= '?success=removedEmplacement';
        } else {
            $redirectUrl .= '?success=modif' . '&oldCode=' . urlencode($oldCode) ;
        }
        $redirectUrl .= '&newCode=' . urlencode($newCode) . '&username=' . urlencode($username);

        header("Location: " . $redirectUrl);
        exit();
    }
}

$users = $usersObject->getAllUsers();
$emplacements = $emplacementObject->getAllEmplacementsNotNull();

$emplacementCount = $emplacementObject->getEmplacementsCount();
$emplacementUsed = $usersObject->emplacementsTaken();
