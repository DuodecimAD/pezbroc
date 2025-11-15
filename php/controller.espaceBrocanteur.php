<?php

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

session_start();

if (!isset($_SESSION['user']['loggedIn'])) {
    header("Location: ../login.php");
    exit;
}

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/utils.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.User.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Objet.php';
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Emplacement.php';

use PEZBroc\User;
use PEZBroc\Objet;
use PEZBroc\Emplacement;

$user = new User();
$objet = new Objet();
$emplacement = new Emplacement();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST["visibilite"]))) {
    $user->isNowVisible($_SESSION['user']['bid']);
    $_SESSION['user']['est_visible'] = true;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['modif']) && isset($_GET['oid'])){
    $objetID = nettoyage_to_db($_GET['oid']);
    $result = $objet->getObjet($objetID);

    if(!$result) {
        $error = "Cet objet n'existe pas.";
    } else if($objet->getBid() !== $_SESSION['user']['bid']){
        $error = "<p>Vous essayez de modifier un objet qui ne vous appartient pas ! tsk tsk</p><img src='https://media.tenor.com/7IGdrM1gJCoAAAAM/dym-tsk-tsk.gif' alt='tsk tsk'>";
    } else {
        $intitule       = nettoyage_from_db($objet->getIntitule() ?? '');
        $description    = nettoyage_from_db($objet->getDescription() ?? '');
        $cid            = nettoyage_from_db($objet->getCid() ?? '');
        $bid            = $_SESSION['user']['bid'];
        $oid            = nettoyage_from_db($objet->getOid() ?? '');
        $image          = nettoyage_from_db($objet->getImage() ?? '');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST["ajouter"]) || isset($_POST["modifier"]))) {

    $intitule       = nettoyage_to_db($_POST['intitule'] ?? '') ;
    $description    = nettoyage_to_db($_POST['description'] ?? '') ;
    $cid            = nettoyage_to_db($_POST['categorie'] ?? '');
    $bid            = $_SESSION['user']['bid'];

    if(isset($_POST['oid'])){
        $oid = nettoyage_to_db($_POST['oid']) ?? '';
    }

    if ($intitule === '') {
        $errorMessage = "Le titre semble incorrect.";
    } elseif ($description === '') {
        $errorMessage = "La description semble incorrect.";
    } elseif ($cid === '') {
        $errorMessage = "La catégorie n'est pas valide.";
    } elseif ($_FILES["image"]['name'] !== "") {
        if($_FILES["image"]["error"] !== UPLOAD_ERR_OK){
            $errorMessage = 'Erreur image upload : ' . $_FILES["image"]["error"];
        } elseif (!getimagesize($_FILES["image"]["tmp_name"])) {
            $errorMessage = "Format image incorrect.";
        } elseif ($_FILES["image"]["size"] > 2000000 ) {
            $errorMessage = "L'image est trop grande. 2MB max.";
        }
    } elseif(isset($_POST["modifier"]) && $objet->getObjet($oid) && $objet->getObjet($oid) && $objet->getBid() !== $_SESSION['user']['bid']) {
        $error = "<p>Vous essayez de supprimer un objet qui ne vous appartient pas ! tsk tsk </p><img src='https://media.tenor.com/7IGdrM1gJCoAAAAM/dym-tsk-tsk.gif' alt='tsk tsk'>";
    }

    if(!isset($errorMessage) && !isset($error)){

        if($_FILES["image"]['name'] !== ""){
            $date = date("dmYHis");
            $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);

            $imageFileType = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $newFileName = "{$randomString}_{$date}.{$imageFileType}";
            $image  = "uploads/" . $newFileName;

            if (isset($_POST["ajouter"])){
                $errorMessage = $objet->insertObjet($intitule, $image, $description, $cid, $bid);
            } else if(isset($_POST["modifier"])){
                $errorMessage = $objet->updateObjetWithImage($oid, $intitule, $image, $description, $cid);
            }
            move_uploaded_file($_FILES["image"]["tmp_name"], $image);

        } else {
            if(isset($_POST["ajouter"])){
                $image  = "uploads/default_image.jpg";
                $errorMessage = $objet->insertObjet($intitule, $image, $description, $cid, $bid);
            } else if(isset($_POST["modifier"])){
                $errorMessage = $objet->updateObjetWithoutImage($oid, $intitule, $description, $cid);
            }
        }

        if($errorMessage === ""){
            if (isset($_POST["modifier"])){
                $locAdd = "?success=modif#scrollHere";
            } else {
                $locAdd = "?success=ajout#scrollHere";
            }
            $redirectUrl = $_SERVER['PHP_SELF'] . $locAdd;
            header("Location: " . $redirectUrl);
            exit;
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del']) && isset($_GET['oid'])){
    $objetID = nettoyage_to_db($_GET['oid']);

    $objet = new Objet();
    $success = $objet->getObjet($objetID);

    if(!$success) {
        $error = "Cet objet n'existe pas.";
    } elseif($objet->getBid() !== $_SESSION['user']['bid']){
        $error = "<p>Vous essayez de supprimer un objet qui ne vous appartient pas ! tsk tsk </p><img src='https://media.tenor.com/7IGdrM1gJCoAAAAM/dym-tsk-tsk.gif' alt='tsk tsk'>";
    } else {
        $image = nettoyage_from_db($objet->getImage() ?? '');
        $intitule = nettoyage_from_db($objet->getIntitule() ?? '');
        $idToDelete = nettoyage_from_db($objet->getOid() ?? '');
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['idToDelete'])){
    $oidToDelete = nettoyage_to_db($_POST['idToDelete']);
    $success = $objet->getObjet($oidToDelete);

    if(!$success){
        $error = "Cet objet n'existe pas";
    } elseif($objet->getBid() !== $_SESSION['user']['bid']){
        $error = "<p>Vous essayez de supprimer un objet qui ne vous appartient pas ! tsk tsk</p><img src='https://media.tenor.com/7IGdrM1gJCoAAAAM/dym-tsk-tsk.gif' alt='tsk tsk'>";
    } else {
        $isDeleted = $objet->deleteObjet($objet->getOid());

        $redirectUrl = $_SERVER['PHP_SELF'] . '?success=del#scrollHere';
        header("Location: " . $redirectUrl);
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_modifProfil'])){
    $brocBid            = $_SESSION['user']['bid'];
    $brocNom            = nettoyage_to_db($_POST['brocNom']) ?? '';
    $brocPrenom         = nettoyage_to_db($_POST['brocPrenom']) ?? '';
    $brocEmail          = filter_var(nettoyage_to_db($_POST['brocCourriel']) ?? '', FILTER_VALIDATE_EMAIL);
    $brocDescription    = nettoyage_to_db($_POST['brocDescription']) ?? '';
    $brocVisible        = isset($_POST['brocVisible']) ? 1 : 0;

    if ($brocNom === '') {
        $modifErrorMessage = "Le nom semble incorrect.";
    } elseif ($brocPrenom === '') {
        $modifErrorMessage = "Le prénom semble incorrect.";
    } elseif (!$brocEmail) {
        $modifErrorMessage = "Votre email n'est pas valide.";
    } else {

        if ($_FILES["avatar"]["error"] !== UPLOAD_ERR_NO_FILE) {

            if ($_FILES["avatar"]["error"] === UPLOAD_ERR_INI_SIZE) {
                $modifErrorMessage = "L'image est trop grande. 2MB max.";
            } elseif (!getimagesize($_FILES["avatar"]["tmp_name"])) {
                    $modifErrorMessage = "Ce n'est pas un fichier image correct.";
            } elseif ($_FILES["avatar"]["error"] !== UPLOAD_ERR_OK) {
                    $modifErrorMessage = "Veuillez utiliser une autre image.";
            } else {
                    $date = date("dmYHis");
                    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 5);
                    $imageFileType = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
                    $newFileName = "{$brocPrenom}_{$brocNom}_{$date}_{$randomString}.{$imageFileType}";
                    $avatar  = "uploads/" . $newFileName;

                if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar)){
                    $modifErrorMessage = "L'image n'a pas pu être uploadée. Essayez une autre.";
                }
            }

        } else {
            $avatar = nettoyage_to_db($_SESSION['user']['photo']);
        }

         if(!isset($errorMessage)) {
            $updateSuccess = $user->updateUser($brocBid, $brocNom, $brocPrenom, $brocEmail, $brocDescription, $avatar, $brocVisible);
            if ($updateSuccess) {
                $user->getUserById($brocBid);
                $user->loadUserIntoSession($user);
                header("Location: " .nettoyage_from_db($_SERVER['PHP_SELF']) . '?brocModifSuccess#');
                exit;
            } else {
                $modifErrorMessage = "La modification a échouée.";
            }
        }
    }
}

$objetsFromUser = $objet->getAllObjetsFromUser($_SESSION['user']['bid']);
$categories = $objet->getCategories();

if($_SESSION['user']['emplacement'] !== null){
    $emplacementCode = $emplacement->getCodeById($_SESSION['user']['emplacement']);
}
