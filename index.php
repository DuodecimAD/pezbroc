<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.index.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Accueil"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="Home_main">
        <div id="Home_img">
            <img src="images/62ed5a2fc5f4b.jpeg" alt="Grande image de distributeurs PEZ">
        </div>

        <section id="Home_who">
            <div class="max-width">
                <h1>Qui sommes-nous</h1>
                <p>Notre foire aux puces est consacrée à la vente et à la revente de distributeurs PEZ,
                    très prisés par les collectionneurs en tout genre à la recherche de pièces manquantes dans
                    leur collection.</p>
                <p>Si vous souhaitez faire partie des exposants, le montant demandé est de 99,99€ la journée.</p>
                <p>Intéressé ? N'hésitez pas à nous rejoindre, il reste encore quelques emplacements de libres.</p>
                <p>La prochaine date est prévue pour le dimanche 29 juin 2025.</p>
            </div>
        </section>

        <section id="Home_ex" class="max-width">
            <h2>Exemples de distributeurs PEZ vendus par nos brocanteurs</h2>

            <?php
            foreach ($rndObjets as $eachObjet) {
                include dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/objetsList.inc.php';
            }
            ?>

        </section>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>