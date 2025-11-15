<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.brocanteur.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Brocanteur"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="Brocanteur" class="max-width">

        <?php if(isset($errorMessage)){ ?>
            <section class="boite">
                <?= $errorMessage ?>
            </section>
        <?php } else { ?>

        <section id="BrocanteurProfil" class="boite">
            <div>
                <img src="<?= $photo ?>" alt="<?= $prenom . '_' . $nom . '_avatar' ?>">
            </div>

            <div>
                <h1><?= $prenom . ' ' . $nom ?></h1>
                <p>Emplacement : <?= $codeEmplacement ?></p>
                <p>Zone : <?= $zoneName ?></p>
                <p style="text-align: justify">Description : <br><?= $description ?></p>
            </div>
        </section>

        <h2>Objets en vente chez <?= $prenom . ' ' . $nom ?></h2>
        <section id="Objets_list" class="boite">
            <?php foreach($objetsFromUser as $eachObjet){ ?>
                <?php include dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/objetsList.inc.php'; ?>
            <?php } ?>
        </section>
        <?php } ?>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>