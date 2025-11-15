<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.brocanteurs.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Brocanteurs"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="Brocanteurs" class="max-width">

        <h1>Brocanteurs</h1>
        <form action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="GET" id="Brocanteurs_search">
            <input type="search" name="search" placeholder="Chercher brocanteur">

            <select	name="zone" title="zone" >
                <option value="">-- Sélectionnez un emplacement --</option>
                <?php foreach ($zones as $zone) { ?>
                <option value="<?= nettoyage_from_db($zone['nom']) ?>"><?= nettoyage_from_db($zone['nom']) ?></option>
                <?php } ?>
            </select>
            <div>
                <button type="submit">Rechercher</button>
                <a href="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>">Réinitialiser</a>
            </div>
        </form>

        <section id="Brocanteurs_list" class="boite">
            <?php
            if (empty($_GET) || empty($_GET["zone"]) && empty($_GET["search"])) {
                include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/brocanteursList.inc.php';
            } else {
                include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/brocanteursFilteredList.inc.php';
            }
            ?>
        </section>

    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>