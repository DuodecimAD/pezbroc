<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.espaceBrocanteur.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Espace Brocanteur"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>

<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="espaceBroc" class="max-width">

        <h1>Espace Brocanteur</h1>

        <?php if(!$_SESSION['user']['a_paye']){ ?>
            <div class="boite errorMessage" style="margin-bottom: 15em;">
                <p>Vous n'avez pas encore payé votre redevance d'emplacement.</p>
                <p>Pour voir les informations de paiement, veuillez vous rendre sur la page suivante : </p>
                <a href="paiement.php" style="width: 12em; margin: 1.25em auto; ">Procéder au paiement</a>
            </div>
        <?php } else if($_SESSION['user']['emplacement'] === null){ ?>
            <div class="boite errorMessage" style="margin-bottom: 15em;">
                <p>Un emplacement ne vous a pas encore été attribué.</p>
                <p>Veuillez patienter le temps que l'admin vous en appointe un. Ce n'est pas moi qui le dis, c'est le cahier des charges préférant un système manuel.</p>
            </div>
        <?php } else if(isset($error)){ ?>
            <div class="boite errorMessage" style="margin-bottom: 15em;">
                <p><?= $error ?></p>
            </div>
        <?php } else { ?>

            <?php if(!$_SESSION['user']['est_visible']) { ?>
                <form action="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>" method="post" class="boite errorMessage">
                    <p>Votre status est invisible.<br>Vos objets ne seront pas montrés aux visiteurs de ce site.</p>
                    <button type="submit" name="visibilite" style="background-color: #c4f7c1;margin: 1em auto;">Me rendre visible</button>
                </form>
            <?php } ?>


            <?php if (isset($_GET['brocModifSuccess'])) { ?>
                <div class="warning good_warning success">
                    <p>Votre profil a bien été modifié.</p>
                </div>
            <?php } ?>

            <?php if (isset($_GET['modifProfil']) || isset($modifErrorMessage)) { ?>

                <form id="brocanteurDonnees" class="sectionLeft boite" method="POST" enctype="multipart/form-data" action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>#brocanteurDonnees">
                    <h2>Vos données</h2>

                    <ul style="text-align:end;max-width:46%;">
                        <li>
                            <label for="brocNom"> Nom * : </label>
                            <input type="text" name="brocNom" id="brocNom" required value="<?= isset($modifErrorMessage) ? $brocNom : nettoyage_from_db($_SESSION['user']['nom']) ?>">
                        </li>
                        <li>
                            <label for="brocPrenom"> Prenom * : </label>
                            <input type="text" name="brocPrenom" id="brocPrenom" required value="<?= isset($modifErrorMessage) ? $brocPrenom : nettoyage_from_db($_SESSION['user']['prenom']) ?>">
                        </li>
                        <li>
                            <label for="brocCourriel"> Courriel * : </label>
                            <input type="text" name="brocCourriel" id="brocCourriel" required value="<?= isset($modifErrorMessage) ? $brocEmail : nettoyage_from_db($_SESSION['user']['courriel']) ?>">
                        </li>
                    </ul>

                    <div style="display:flex;flex-direction:column;align-items:center;gap: .5em;">
                        <img src="<?= nettoyage_from_db($_SESSION['user']['photo']) ?>" id="previewAvatar" alt="ma_photo">
                        <input type="file" name="avatar" id="avatar" accept="image/*" style="width:80%;"
                               onchange="const f = this.files[0]; if (f) { const r = new FileReader(); r.onload = (e) => document.getElementById('previewAvatar').src = e.target.result; r.readAsDataURL(f); }">
                    </div>


                    <label for="brocVisible" style="margin: 1em auto 0;">Voulez-vous, ainsi que vos objets, être visibles par les visiteurs :
                        <input type="checkbox" name="brocVisible" id="brocVisible" <?php if(isset($modifErrorMessage)){ if($brocVisible == 1) {echo "checked";} } elseif($_SESSION['user']['est_visible'] == 1){ echo"checked"; } ?>>
                    </label>

                    <div style="width:100%">
                        <label for="brocDescription" style="line-height: 3em;">Description * : </label><br>
                        <textarea name="brocDescription" id="brocDescription" rows="10" placeholder="Entrez votre description" required style="width: calc(100% - .7em);"><?= isset($modifErrorMessage) ? $brocDescription : nettoyage_from_db($_SESSION['user']['description']) ?></textarea>
                    </div>

                    <div style="display:flex;flex-direction:column;align-items:center;margin:auto;gap:.8em;">
                        <button type="submit" name="submit_modifProfil">Valider</button>
                        <a href="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>" class="revert">Annuler</a>
                    </div>
                    <div class="invisibleMagicBox"></div>

                    <?= isset($modifErrorMessage) ? "<span class='errorMessage'>$modifErrorMessage</span>" : "" ?>
                </form>

            <?php } else { ?>
                <section id="brocanteurDonnees" class="sectionLeft boite">
                    <h2>Vos données</h2>
                    <ul>
                        <li>Nom : <?= nettoyage_from_db($_SESSION['user']['nom']) ?></li>
                        <li>Prenom : <?= nettoyage_from_db($_SESSION['user']['prenom']) ?></li>
                        <li>Courriel : <?= nettoyage_from_db($_SESSION['user']['courriel']) ?></li>
                        <li>Vous <?= $_SESSION['user']['est_visible'] == 1 ? "êtes visible" : "n'êtes pas visible" ?> sur le site.</li>
                    </ul>
                    <img src="<?= nettoyage_from_db($_SESSION['user']['photo']) ?>" alt="ma_photo">
                    <div class="invisibleMagicBox"></div>
                    <p><span style="line-height: 3em;">Description : </span><br> <?= nettoyage_from_db($_SESSION['user']['description']) ?></p>
                    <div class="invisibleMagicBox"></div>
                    <a href="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>?modifProfil#brocanteurDonnees">Modifier</a>
                    <div class="invisibleMagicBox"></div>
                    <a href="reinitialisationmdp.php">changer mot de passe ?</a>

                </section>
            <?php } ?>

            <div class="sectionRight boite">
                <p class="warning good_warning">L'emplacement<br><?= $emplacementCode ?><br>vous est attribué.</p>
            </div>

            <div id="scrollHere" style="width: 100%;display:<?= !empty($_GET) ? "block" : "none" ?>;"></div>

            <?php if (isset($_GET['success'])) { ?>
                    <div class="warning good_warning success">
                        <?php if($_GET['success'] === 'del'){ ?>
                            <p>L'objet a bien été supprimé.</p>
                        <?php } else if($_GET['success'] === 'modif'){ ?>
                            <p>L'objet a bien été modifié.</p>
                        <?php } else if($_GET['success'] === 'ajout'){ ?>
                            <p>L'objet a bien été ajouté.</p>
                        <?php } ?>
                    </div>
            <?php }  ?>

            <section id="Objets_list" class="sectionLeft boite">
                <h2>Vos objets</h2>
                <?php foreach($objetsFromUser AS $eachObjet){ ?>
                <?php include dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/objetsList.inc.php'; ?>
                <?php } ?>
            </section>


            <form action="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="post" class="sectionRight boite" <?php if(isset($errorMessage)) {?>style="max-height: 60em;"<?php } ?>>
                <?php if(isset($_GET['modif']) || isset($_POST['modifier'])) { ?>
                    <h2>Modifier objet</h2>
                    <input type="hidden" name="oid" value="<?php if(isset($oid)){ echo $oid; } ?>">

                <?php } else if(isset($_GET['del'])) { ?>
                    <h2>Supprimer objet</h2>
                <?php } else { ?>
                    <h2>Ajouter objet</h2>
                <?php } ?>

                <?php if (isset($_GET['del'])) { ?>
                    <?php if(isset($errorMessage)){ ?>
                        <p><?= $errorMessage ?></p>
                    <?php } else { ?>
                        <img src="<?= $image ?? 'uploads/default_image.jpg'; ?>" id="previewImage" alt="photo objet">
                        <h2><?php if(isset($intitule)){ echo $intitule; } ?></h2>
                        <p>Êtes-vous absolument certain de vouloir supprimer cet objet ?</p>

                        <form method="post" action='<?= nettoyage_to_db($_SERVER["PHP_SELF"]); ?>'>
                            <input type="hidden" name="idToDelete" value="<?= $idToDelete; ?>">
                            <button type="submit" name="delete" class="submit_delete">Oui, supprimer</button>
                            <a href="<?= nettoyage_to_db($_SERVER["PHP_SELF"]); ?>" class="revert">Annuler</a>
                        </form>


                    <?php }
                } else { ?>

                    <img src="<?= $image ?? 'uploads/default_image.jpg'; ?>" id="previewImage" alt="ajouter photo">
                    <input type="file" name="image" id="image" accept="image/*"
                            onchange="const f = this.files[0]; if (f) { const r = new FileReader(); r.onload = (e) => document.getElementById('previewImage').src = e.target.result; r.readAsDataURL(f); }"
                            >

                    <label for="intitule">Titre *</label>
                    <input type="text" id="intitule" name="intitule" placeholder="Titre de l'objet"
                         value="<?php if(isset($intitule)){ echo $intitule; } ?>" required>

                    <label for="categorie">Catégorie *</label>
                    <select	name="categorie" title="categorie" id="categorie" required>
                        <option value="">-- Sélectionnez une catégorie --</option>
                        <?php foreach ($categories as $cat) {?>
                            <option value="<?= nettoyage_from_db($cat['cid']) ?>" <?=
                            isset($cid) && $cid == $cat['cid'] ? 'selected' : ''; ?>>
                            <?= nettoyage_from_db($cat['intitule'])?></option>
                        <?php } ?>

                    </select>

                    <label for="description">Description *</label>
                    <textarea name="description" id="description" rows="10" maxlength="450" placeholder="Entrez votre description" required><?php
                        if(isset($description)){ echo $description; }
                        ?></textarea>
                    <?php if(isset($_GET['modif']) || isset($_POST['modifier'])) { ?>
                    <button type="submit" name="modifier">Modifier</button>
                    <?php } else { ?>
                    <button type="submit" name="ajouter">Ajouter</button>
                    <?php } ?>

                    <?php if(isset($errorMessage)) { ?>
                        <p class="errorMessage"><?= $errorMessage ?><br>Veuillez fournir à nouveau une image si vous en souhaitez une.</p>
                    <?php  }?>
                <?php } ?>

            </form>

        <?php } ?>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>
</body>
</html>
