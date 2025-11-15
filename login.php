<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.login.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Me connecter"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main class="max-width">
        <h1>Me connecter</h1>
        <form action="<?php echo nettoyage_from_db($_SERVER['PHP_SELF']) ?>#login_form" method="post" id="login_form" class="boite" style="position: relative;">
            <div>
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" required placeholder="Entrez votre email" <?php if(isset($email)){ echo 'value="' . $email . '"'; } ?>>

                <label for="password">Mot de passe *</label>
                <input type="password" name="password" id="password" class="mdp" required placeholder="Entrez votre mot de passe">

                <button type="submit" name="submit">Me connecter</button>
                <a href="reinitialisationmdp.php" id="mdpForgot">Mot de passe oublié ?</a>
            </div>

            <?php if(isset($errorMessage)) {
                echo '<p class="errorMessage">' . nettoyage_from_db($errorMessage) . '</p>';
                unset($errorMessage);
            }?>

            <div id="loginHelp">
                <p><b>Admin</b><br>admin@admin.aa<br>Admin</p>
                <p><b>Payé, emplacement, visible</b><br>broc@broc.aa<br>Broc</p>
                <p><b>Payé, emplacement, pas visible</b><br>tw@tw.aa<br>Wamba</p>
                <p><b>Payé, Pas d'emplacement</b><br>dp@dp.aa<br>Petit</p>
                <p><b>Pas payé</b><br>kd@kd.aa<br>Dallas</p>
            </div>
        </form>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>