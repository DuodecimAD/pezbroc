<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';

use PEZBroc\User;

if (isset($_SESSION["login"])){
    header("Location: index.php");
} else if ($_SESSION['user']['a_paye']){
    header("Location: espaceBrocanteur.php");
}else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["paiement"])) {

    $user = new User();

    if($user->isDonePaying($_SESSION['user']['bid'])){
        $_SESSION['user']['a_paye'] = true;
        header("Location: espaceBrocanteur.php");
    } else {
        echo "something went wrong";
    }

}