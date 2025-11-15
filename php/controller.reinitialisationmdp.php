<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';

use PEZBroc\User;

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit_modifPassword"])) {
    if(isset($_SESSION['user'])){
        $bid = $_SESSION['user']["bid"];
    } elseif(isset($_POST["bid"])) {
        $bid = nettoyage_to_db($_POST["bid"]);
    }

    $password       = nettoyage_to_db($_POST['password']) ?? '';
    $passwordVerif  = nettoyage_to_db($_POST['passwordVerif']) ?? '';

    if($password === ''){
        $errorMessage = "Le mot de passe est vide.";
    } elseif($passwordVerif === ''){
        $errorMessage = "Le mot de passe de vérification est vide.";
    } elseif($password !== $passwordVerif) {
        $errorMessage = "Les mots de passe ne correspondent pas.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        if ($user->updatePassword($hashedPassword, $bid)) {
            header("Location: {$_SERVER['PHP_SELF']}?success");
            exit;
        } else {
            $errorMessage = "La modification n'a pas fonctionnée. Veuillez contacter un administrateur.";
        }

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit_reinitPassword"])) {

    $email = filter_var(nettoyage_to_db($_POST['email']) ?? '', FILTER_VALIDATE_EMAIL);
    if(!$email){
        $errorMessage = "Votre email est incorrect.";
    } else {
        $userFromEmail = $user->getUserByEmail($email);
        if($userFromEmail){
            $bid = $user->getBid();
            $to      = $email;
            $subject = "Re: PEZBroc - reset password";

            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
            $host     = $_SERVER['HTTP_HOST'];
            $self     = $_SERVER['PHP_SELF'];
            $fullUrl = $protocol . "://" . $host . $self;

            $link = $fullUrl."?reinitPassword&bid=$bid";

            $newPassword = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#!"), 0, 7);
            $newPasswordToDb = password_hash($newPassword, PASSWORD_DEFAULT);

            $message = <<<HTML
                <html>
                <head>
                    <title>HTML email</title>
                </head>
                <body>
                    <div style='padding: 20px;background-color: #e9ecef;border: solid lightslategrey .1333rem; max-width: 500px; text-align: center;'>
                        <p>Réinitialisation de votre mot de passe</p>
                        <p>From : PEZBroc</p>
                        <p>---------------------------</p>
                        <p>Votre nouveau mot de passe : <b>{$newPassword}</b></p>
                        <p>Vous avez la possibilité de choisir vous-même un nouveau mot de passe :</p> 
                        <a href='{$link}'>Changer mot de passe</a>
                        <p>---------------------------</p>
                    </div>
                </body>
                </html>
                HTML;

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: no-reply@helmo.be" . "\r\n";
            $headers .= "Reply-To: no-replu@pezbroc.aa" . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

            if(mail($to, $subject, $message, $headers)){
                $success = true;
                $user->updatePassword($newPasswordToDb, $bid);
            } else {
                $errorMessage = "Votre mail n'a pas pu être envoyé. Contactez un administrateur ...";
            }

        } else {
            $errorMessage = "Cet email n'existe pas.";
        }
    }




}