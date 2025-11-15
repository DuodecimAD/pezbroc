<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';

use PEZBroc\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(nettoyage_to_db($_POST['email']) ?? '', FILTER_VALIDATE_EMAIL);
    $password = nettoyage_to_db($_POST['password']) ?? '';

    $user = new User();

    if (!$email) {
        $errorMessage = "Votre email n'est pas valide.";
    } else if (!$user->getUserByEmail($email)) {
        $errorMessage = "Votre email n'existe pas.";
    } else {

        $dbPassword = $user->getMotPasse();

        if (!password_verify($password, $dbPassword)) {
            $email = nettoyage_to_db($_POST['email']);
            $errorMessage = "Votre mot de passe est incorrect.";
        } else {
            $user->loadUserIntoSession($user);
            unset($errorMessage);
            header("Location: " . ($_SESSION['user']['est_administrateur'] ? "espaceAdmin.php" : "espaceBrocanteur.php"));
            exit;
        }
    }
}