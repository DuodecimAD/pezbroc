<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Objet.php';

use PEZBroc\Objet;

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['oid'])){

    $oid = nettoyage_to_db($_GET['oid']);

    $objet = new Objet();
    $success = $objet->getObjet($oid);

    if(!$success){
        $errorMessage = "<p class='errorMessage'>Cet objet n'existe pas</p>";
    } else {

        $intitule    = nettoyage_from_db($objet->getIntitule());
        $image       = nettoyage_from_db($objet->getImage());
        $description = nettoyage_from_db($objet->getDescription());
        $cid         = nettoyage_from_db($objet->getCid());
        $bid         = nettoyage_from_db($objet->getBid());
        $codeEmplacement = nettoyage_from_db($objet->getCode());
        $zone        = nettoyage_from_db($objet->getZone());
        $categorie   = nettoyage_from_db($objet->getCategorie());
        $bprenom     = nettoyage_from_db($objet->getBprenom());
        $bnom        = nettoyage_from_db($objet->getBnom());
        $userFullName = $bprenom . ' ' . $bnom ;
    }
}
