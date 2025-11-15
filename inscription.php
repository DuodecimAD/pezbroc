<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.inscription.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Inscription"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main class="max-width">
        <h1>M'inscrire</h1>

        <?php if($emplacementsTaken >= MAX_EMPLACEMENTS){ ?>
            <section class="boite bad_warning">
                <p>"Les inscriptions sont cloturées, tous les emplacements ont été attribués."</p>
            </section>
        <?php } else { ?>

            <form action="<?php echo nettoyage_from_db($_SERVER['PHP_SELF']) ?>#inscription_form" enctype="multipart/form-data" method="post" id="inscription_form" class="boite">

                <div>

                    <label for="prenom">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" required placeholder="Entrez votre prénom"
                        <?php if(isset($prenom)){ ?> value="<?php echo nettoyage_from_db($prenom) ?>"<?php }
                        ?>>

                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" id="nom" required placeholder="Entrez votre nom"
                        <?php if(isset($nom)){ ?> value="<?php echo nettoyage_from_db($nom) ?>"<?php }
                        ?>>

                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" required placeholder="Entrez votre email"
                        <?php if(isset($email)){ ?> value="<?php echo nettoyage_from_db($email) ?>"<?php }
                        ?>>
                </div>

                <div>
                    <img src="images/inconnu.jpg" id="previewAvatar" alt="ajouter photo">
                    <input type="file" name="avatar" id="avatar" accept="image/*"
                           onchange="const f = this.files[0]; if (f) { const r = new FileReader(); r.onload = (e) => document.getElementById('previewAvatar').src = e.target.result; r.readAsDataURL(f); }">
                </div>

                <div>
                    <div>
                        <label for="password">Mot de passe *</label>
                        <input type="password" name="password" id="password" class="mdp" required placeholder="Entrez votre mot de passe"
                            <?php if(isset($password)){ ?> value="<?php echo nettoyage_from_db($password) ?>"<?php } ?>
                        >
                    </div>

                    <div>
                        <label for="passwordVerif">Vérification mot de passe *</label>
                        <input type="password" name="passwordVerif" id="passwordVerif" class="mdp" required placeholder="Répétez votre mot de passe"
                            <?php if(isset($passwordVerif)){ ?> value="<?php echo nettoyage_from_db($passwordVerif) ?>"<?php } ?>
                        >
                    </div>
                </div>

                <div>
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" rows="17" cols="64" placeholder="Entrez votre description"><?php
                        if(isset($description)){ echo nettoyage_from_db($description); }
                        ?></textarea>
                </div>

                <div>
                    <label for="visible">Souhaiter-vous être visible sur le site, permettant ainsi aux
                        visiteurs de visualiser votre profil, ainsi que vos objets ?</label>
                    <input type="checkbox" name="visible" id="visible" checked>
                    <label for="peaceOut" class="peaceOut">peaceOut<input type="text" name="peaceOut" id="peaceOut"></label>
                </div>

                <div>
                    <a href="index.php" class="annuler">Annuler</a>
                    <button type="submit" name="submit">Valider</button>
                    <a href="login.php" id="dejaCompte">Déjà un compte ?</a>
                </div>

                <?php if(isset($errorMessage)) { ?>
                    <p class="errorMessage"><?= nettoyage_from_db($errorMessage) ?><br>Veuillez fournir à nouveau une photo si vous en souhaitez une.</p>

                <?php } ?>

            </form>
        <?php }?>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>