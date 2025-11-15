<?php
if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}
?>

<?php

if (!empty($_GET["zone"])) {
    $selectedZone = null;
    foreach ($zones as $zone) {
        if ($zone["nom"] === $_GET["zone"]) {
            $selectedZone = $zone;
            break;
        }
    }
    ?>

    <h2><?= nettoyage_from_db($selectedZone['nom']) . ' - ' . nettoyage_from_db($selectedZone['description']) ?></h2>

    <?php
}

$noBrocanteurBool = false;

foreach ($brocanteurs as $brocanteur) {

    $isSearchExist = empty($_GET['search'])
        || (stripos($brocanteur['nom'], $_GET['search']) !== false
            || stripos($brocanteur['prenom'], $_GET['search']) !== false
                || stripos($brocanteur['prenom'] . ' ' . $brocanteur['nom'], $_GET['search']) !== false);
    $isZoneExist = empty($selectedZone) || $brocanteur['zone'] === $selectedZone['nom'];

    if ($isSearchExist && $isZoneExist && $brocanteur['visible']) {
        include dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/brocanteursFiltered.inc.php';
        $noBrocanteurBool = true;
    }
}

if(!$noBrocanteurBool){
    echo "<p>Aucun brocanteur n'a été trouvé avec les paramètres de filtres fournis.</p>";
}