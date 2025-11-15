<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.contact.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Contact"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main class="max-width">
        <h1>Contact</h1>

        <?php if(isset($success)) { ?>
            <div class="warning good_warning success">
                <p>Votre message a été envoyé avec succès</p>
            </div>

        <?php } else { ?>

            <form action="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>#contact_form" method="post" id="contact_form" class="boite">

                <label for="email">Email *</label>
                <input type="email" name="email" id="email" required placeholder="Entrez votre email"
                       value="<?php if(isset($sujetEmail)){ echo $sujetEmail; } else if(isset($_SESSION['user']['courriel'])){ echo $_SESSION['user']['courriel']; } ?>">

                <label for="peaceOut" class="peaceOut">peaceOut<input type="text" name="peaceOut" id="peaceOut"></label>

                <label for="sujet">Sujet *</label>
                <input type="text" name="sujet" id="sujet" required placeholder="Entrez le sujet de votre message" value="<?php if(isset($sujet)){ echo $sujet; } ?>">

                <label for="message">Message *</label>
                <textarea name="message" id="message" rows="17" cols="75" required placeholder="Entrez votre message"><?php if(isset($content)){ echo $content; } ?></textarea>

                <button type="submit" name="submit">Envoyer</button>
                <?php if(isset($errorMessage)) { ?>
                    <p class="errorMessage"><?= nettoyage_from_db($errorMessage) ?></p>
                <?php } ?>
            </form>

        <?php } ?>

    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>