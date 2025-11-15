<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.reinitialisationmdp.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Réinitialiser mot de passe"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main class="max-width">
        <h1>Réinitialiser mot de passe</h1>

        <?php if(isset($success)) { ?>
            <div class="warning good_warning success">
                <p>Un mail vous a été envoyé à votre adresse avec un nouveau mot de passe.</p>
                <p>Veuillez cliquer le lien pour changer votre mot de passe si vous désirez choisir vous-même un nouveau mot de passe.</p>
            </div>

        <?php } elseif (isset($_GET['success'])){ ?>

            <div class="warning good_warning success">
                <p>Votre mot de passe a été changé avec succès.</p>
            </div>

        <?php } else { ?>

            <form action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="post" id="reinitialisationmdp_form" class="boite">

                <?php if(isset($_SESSION['user']) || isset($_GET["reinitPassword"]) || isset($_POST['bid'])){ ?>
                    <div>
                        <label for="password">Mot de passe *</label>
                        <input type="password" name="password" id="password" class="mdp" required placeholder="Entrez votre mot de passe"
                            <?php if(isset($password)){ ?> value="<?php echo nettoyage_from_db($password) ?>"<?php } ?>
                        >
                    </div>

                    <?php if(isset($_GET["reinitPassword"])){  ?>
                        <input type="hidden" name="bid" value="<?= nettoyage_from_db($_GET['bid']); ?>">
                    <?php } elseif(isset($_POST['bid'])){?>
                        <input type="hidden" name="bid" value="<?= nettoyage_from_db($_POST['bid']); ?>">
                    <?php }?>
                    <div>
                        <label for="passwordVerif">Vérification mot de passe *</label>
                        <input type="password" name="passwordVerif" id="passwordVerif" class="mdp" required placeholder="Répétez votre mot de passe"
                            <?php if(isset($passwordVerif)){ ?> value="<?php echo nettoyage_from_db($passwordVerif) ?>"<?php } ?>
                        >
                    </div>

                    <div>
                        <a href="espaceBrocanteur.php" class="annuler">Annuler</a>
                        <button type="submit" name="submit_modifPassword" >Valider</button>
                    </div>

                <?php } else { ?>
                    <section>
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" required placeholder="Entrez votre email"
                            <?php if(isset($email)){ ?> value="<?php echo nettoyage_from_db($email) ?>"<?php } ?>
                        >
                    </section>

                    <section>
                        <a href="index.php" class="annuler">Annuler</a>
                        <button type="submit" name="submit_reinitPassword">Réinitialiser</button>
                    </section>
                <?php } ?>

                <?php if(isset($errorMessage)) { ?>
                    <p class="errorMessage"><?= nettoyage_from_db($errorMessage) ?></p>

                <?php } ?>
            </form>
        <?php } ?>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>