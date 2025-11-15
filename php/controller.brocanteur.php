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

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['bid'])){

    $bid = nettoyage_to_db($_GET['bid']);

    $user = new User();
    $objet = new Objet();

    $success = $user->getUserById($bid);

    if(!$success){
        $errorMessage = "<p class='errorMessage'>Ce brocanteur n'existe pas</p>";
    } else {
        $nom        = nettoyage_from_db($user->getNom());
        $prenom     = nettoyage_from_db($user->getPrenom());
        $courriel   = nettoyage_from_db($user->getCourriel());
        $photo      = nettoyage_from_db($user->getPhoto());
        $description = nettoyage_from_db($user->getDescription());
        $eid        = nettoyage_from_db($user->getEid());
        $zoneName   = nettoyage_from_db($user->getZone());
        $codeEmplacement = nettoyage_from_db($user->getCode());

        $objetsFromUser = $objet->getAllObjetsFromUser($bid);
    }


}