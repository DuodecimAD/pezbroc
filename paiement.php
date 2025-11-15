<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.paiement.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "paiement"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/inc/head.inc.php"; ?>
<body>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/inc/header.inc.php"; ?>

    <main class="max-width">
        <h1>Page paiement</h1>

        <?php if(isset($_GET['inscription'])){ ?>
            <section class="boite good_warning" style="margin-bottom: 2.5em;">
                <p>Votre compte a bien été créé.</p>
            </section>
        <?php } ?>

        <section class="boite">
            <p>Foire aux puces PEZBroc' <br> réservation n°<?= $_SESSION['user']['bid'] ?></p>
            <p>Le montant de la participation est de <strong>49,99€</strong></p>
            <p>Vous pouvez payer soit par virement sur le compte :<br>
            BEXX XXXX XXXX XXXX<br>
            avec la communication structurée :<br>
            +++ XXX/XXXX/XXXXX +++<br>
            ou en scannant ce QR code :</p>
            <div style="width : 200px; height : 200px;" class="boite"><p style="line-height: 8em;">QR CODE</p></div>
            <a href="espaceBrocanteur.php" style="width: fit-content; margin: 1.25em auto;">Payer plus tard</a>

            <form action="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>" method="post">
                <button type="submit" name="paiement" style="margin-top: 2em;" class="good_warning">Ok, J'ai payé</button>
            </form>
        </section>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/inc/footer.inc.php"; ?>

</body>
</html>