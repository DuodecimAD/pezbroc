<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

if (!empty($_POST['peaceOut'])) {
    http_response_code(403);
    exit('Peace out mr. Bot.');
}

session_start();

if (isset($_SESSION['user']['loggedIn'])) {
    header("Location: index.php");
    exit;
}
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';

use PEZBroc\User;

$user = new User();
$emplacementsTaken = $user->emplacementsTaken();
const MAX_EMPLACEMENTS = 60;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {

    $nom            = nettoyage_to_db($_POST['nom']) ?? '';
    $prenom         = nettoyage_to_db($_POST['prenom']) ?? '';
    $email          = filter_var(nettoyage_to_db($_POST['email']) ?? '', FILTER_VALIDATE_EMAIL);
    $password       = nettoyage_to_db($_POST['password']) ?? '';
    $passwordVerif  = nettoyage_to_db($_POST['passwordVerif']) ?? '';
    $description    = nettoyage_to_db($_POST['description']) ?? '';
    $visible        = isset($_POST['visible']) ? 1 : 0;


    if ($nom === '') {
        $errorMessage = "Le nom semble incorrect.";
    } else if ($prenom === '') {
        $errorMessage = "Le prénom semble incorrect.";
    } else if (!$email) {
        $errorMessage = "Votre email n'est pas valide.";
    } else if ($password !== $passwordVerif) {
        $errorMessage = "Votre mot de passe est différent.";
    } else {

        if ($user->checkIfUserEmailExists($email)) {
            $errorMessage = "Cet email existe déjà";
        } else {

            // 4 = pas de photo uploadée
            if ($_FILES["avatar"]["error"] !== 4) {

                if (!getimagesize($_FILES["avatar"]["tmp_name"])) {
                    $errorMessage = "Format image incorrect.";
                }  elseif (!getimagesize($_FILES["avatar"]["tmp_name"])) {
                    $errorMessage = "Ce n'est pas un fichier image correct.";
                } elseif ($_FILES["avatar"]["error"] !== 0) {
                    $errorMessage = "Veuillez utiliser une autre image.";
                } else {
                    $date = date("dmYHis");
                    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 5);

                    $imageFileType = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
                    $newFileName = "{$prenom}_{$nom}_{$date}_{$randomString}.{$imageFileType}";
                    $avatar  = "uploads/" . $newFileName;

                    if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar)){
                        $errorMessage = "L'image n'a pas pu être uploadée. Essayez une autre.";
                    }
                }

            } else {
                $avatar = 'uploads/default_avatar.jpg';
            }

            if(!isset($errorMessage)){
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertSuccess = $user->insertUser($nom, $prenom, $email, $hashedPassword, $avatar, $description, $visible);
                if($insertSuccess){
                    $user->getUserByEmail($email);
                    $user->loadUserIntoSession($user);
                    header("Location: paiement.php?inscription#");
                    exit;
                } else {
                    $errorMessage = "La modification a échouée.";
                }
            }
        }
    }
}

