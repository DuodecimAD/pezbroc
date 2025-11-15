<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.objets.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Objets"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php';?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="Objets" class="max-width">
        <h1>Objets</h1>

        <form action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="GET" id="Objets_search">

            <label>
                <input type="search" name="search" placeholder="Par objets ou brocanteurs" value="<?= isset($_GET['search']) ? nettoyage_from_db($_GET['search']) : '' ?>">
            </label>

            <div>
            <?php foreach($categories as $categorie){ ?>
                <label>
                    <input type="checkbox" name="oCats[]" value="<?= $categorie['intitule'] ?>"
                        <?= isset($_GET["oCats"]) &&  in_array($categorie['intitule'], $_GET["oCats"]) ? 'checked' : '' ?>>
                    <?= $categorie['intitule'] ?>
                </label>
            <?php } ?>
            </div>

            <select name="brocanteursSelect" id="brocanteursSelect">
                <option value="">-- Liste des Brocanteurs --</option>
                <?php foreach ($users as $eachUser) {?>
                    <option <?php if(isset($_GET['brocanteursSelect'])){ if(urldecode($_GET['brocanteursSelect']) === nettoyage_from_db($eachUser['prenom']) . ' ' . nettoyage_from_db($eachUser['nom'])){ echo 'selected'; }} ?> value="<?= nettoyage_from_db($eachUser['prenom']) . ' ' . nettoyage_from_db($eachUser['nom']) ?>" ><?= nettoyage_from_db($eachUser['prenom']) . ' ' . nettoyage_from_db($eachUser['nom']) ?></option>
                <?php } ?>
            </select>

            <div>
                <button type="submit">Rechercher</button>
                <a href="<?= nettoyage_from_db($_SERVER['PHP_SELF']) . '?resetCookie' ?>">Réinitialiser</a>
            </div>
        </form>

        <section id="Objets_list" class="boite">
            <?php

            foreach($categories as $categorie){
                $showTitle = true;
                // N'affiche que les categories selectionnées avec les checkbox dans search
                if (!empty($oCats) && !in_array($categorie['intitule'], $oCats)) {
                    continue;
                }

                foreach ($objets as $eachObjet) {

                    $isSearchExist = empty($_GET['search']);

                    if(!$isSearchExist){

                        $searchKeywords = explode(' ', $_GET['search']);

                        foreach ($searchKeywords as $searchKeyword) {
                            if (stripos($eachObjet['intitule'], $searchKeyword) !== false ||
                                stripos($eachObjet['description'], $searchKeyword) !== false ||
                                stripos($eachObjet['bnom'], $searchKeyword) !== false ||
                                stripos($eachObjet['bprenom'], $searchKeyword) !== false) {
                                $isSearchExist = true;
                                break;
                            }
                        }
                    }

                    $isCategorieExist = $eachObjet['cid'] === $categorie['cid'];

                    $isBrocanteurExist =  empty($_GET['brocanteursSelect']);

                    if(!$isBrocanteurExist){

                        $brocanteursKeywords = explode(' ', $_GET['brocanteursSelect']);

                        foreach ($brocanteursKeywords as $brocanteurKeyword) {
                            if (stripos($eachObjet['bnom'], $brocanteurKeyword) !== false ||
                                stripos($eachObjet['bprenom'], $brocanteurKeyword) !== false) {
                                $isBrocanteurExist = true;
                                break;
                            }
                        }
                    }

                    if ($isSearchExist && $isCategorieExist && $isBrocanteurExist) {
                        if($showTitle){
                            ?>
                            <h2><?= $categorie['intitule'] ?></h2>
                            <?php
                        $showTitle = false;
                        }
                        include dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/objetsList.inc.php';
                        $noObjetBool = true;
                    }
                }
            }
            if(!$noObjetBool){
                echo "<p>Aucun objet n'a été trouvé avec les paramètres de filtres fournis.</p>";
            }
            ?>

        </section>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>