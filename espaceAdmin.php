<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.espaceAdmin.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Espace Administrateur";  include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="espaceAdmin" class="max-width">
        <h1>Espace Administrateur</h1>

        <a href="<?php nettoyage_from_db($_SERVER['PHP_SELF']) ?>?reloadDeleted" style="background-color: lightgray; position:absolute; right:1em;margin:5px; display: none;">reload suppressions</a>

        <?php if (isset($_GET['success'])) { ?>
            <div class="warning good_warning success">
                <?php if($_GET['success'] === 'del'){ ?>
                    <p>Le brocanteur <?= nettoyage_from_db($_GET['username']) ?><?= isset($_GET['hadEmplacement']) ? ' a bien été déconnecté de son emplacement.<br> Son compte ainsi que tous ses objets ont été supprimés.' : 'a bien été supprimé.' ?></p>
                <?php } elseif($_GET['success'] === 'modif'){ ?>
                    <p>L'emplacement du brocanteur <?= nettoyage_from_db($_GET['username']) ?> a bien été modifié de <?= nettoyage_from_db($_GET['oldCode']) ?> vers <?= nettoyage_from_db($_GET['newCode']) ?></p>
                <?php } elseif($_GET['success'] === 'ajout'){ ?>
                    <p>L'emplacement <?= nettoyage_from_db($_GET['newCode']) ?> a été assigné au brocanteur <?= nettoyage_from_db($_GET['username']) ?></p>
                <?php } elseif($_GET['success'] === 'removedEmplacement'){ ?>
                    <p>Le brocanteur <?= nettoyage_from_db($_GET['username']) ?> n'est plus lié à un emplacement.</p>
                <?php } ?>
            </div>
        <?php } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["submit_delete"])) {
            $username = nettoyage_from_db($_GET['username']) ?? '';
            $idToDelete = nettoyage_from_db($_GET['userId']) ?? '';

            $hasEmplacement = $usersObject->hasEmplacement($idToDelete);
        ?>
            <form class="warning bad_warning delete_confirmation" action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="POST">
            <input type="hidden" name="username" value="<?= $username ?>">
            <input type="hidden" name="idToDelete" value="<?= $idToDelete; ?>">

            <?php if($hasEmplacement){ ?>
                <p><?= $username ?> est lié à un emplacement. Vous ne pouvez pas supprimer ce brocanteur.</p>
                <p>Souhaitez-vous déconnecter <?= $username ?> de son emplacement,<br>supprimer son compte et tous ses objets ?</p>
                <p>Si vous souhaitez seulement libérer son emplacement, sélectionner "libérer emplacement" dans la liste de modification d'emplacement.</p>
                <input type="hidden" name="hadEmplacement">
            <?php } else { ?>
                <p>Êtes-vous certain de vouloir supprimer le brocanteur <?= $username ?> ?</p>
            <?php } ?>
                <div style="display:flex;flex-direction: column; gap: 0.7em;">
                    <button type="submit" name="submit_delete" class="submit_delete">Oui, supprimer</button>
                    <a href="<?= nettoyage_to_db($_SERVER["PHP_SELF"]); ?>" class="revert">Annuler</a>
                </div>
            </form>

        <?php } elseif (isset($errorMessage)){ ?>
            <div class="warning bad_warning"><?= $errorMessage ?></div>
        <?php } ?>

        <section class="espaceAdmin_list boite">

            <?php if(isset($users)){ ?>
            <h2>Emplacement non attribué</h2>
            <?php
                foreach ($users as $index => $user){
                    // si admin -> skip
                    if ($index === 0) continue;
                    // si pas payé -> skip
                    if (!$user['a_paye']) continue;
                    // si emplacement attribué -> skip
                    if ($user['eid'] !== null) continue;

                    $cleanedUserBid     = nettoyage_from_db($user['bid']);
                    $cleanedUserPrenom  = nettoyage_from_db($user['prenom']);
                    $cleanedUserNom     = nettoyage_from_db($user['nom']);
                    $cleanedUserPhoto   = nettoyage_from_db($user['photo']);

            ?>

            <article>
                <div>
                    <img src="<?= $cleanedUserPhoto ?>" alt="<?= $cleanedUserPrenom . '_' . $cleanedUserNom . '_avatar' ?>">
                </div>
                <div>
                    <h3><?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?></h3>
                    <p>ID <?= $cleanedUserBid ?></p>
                    <p>Emplacement : Non attribué</p>
                </div>

                <form action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="post">
                    <input type="hidden" name="userId" value="<?= $cleanedUserBid ?>">

                    <input type="hidden" name="username" value="<?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?>">

                    <label for="emplacements_<?= $cleanedUserBid ?>">Attribuer :</label>
                    <select name="emplacements" id="emplacements_<?= $cleanedUserBid ?>" required>
                        <option value="">-- Sélectionnez un emplacement --</option>
                        <?php foreach ($emplacements as $emplacement) {?>
                            <option value="<?= nettoyage_from_db($emplacement['code']); ?>" ><?= nettoyage_from_db($emplacement['code']) ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" name="modif">Valider</button>
                </form>
                <form style="border-left: 0.2em solid #cccccc;padding : 0 0.8em;" action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="GET">
                    <p style="margin: 0.3em 0;">Supprimer brocanteur</p>
                    <input type="hidden" name="userId" value="<?= $cleanedUserBid ?>">
                    <input type="hidden" name="username" value="<?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?>">
                    <button type="submit" name="submit_delete" class="submit_delete">Supprimer</button>
                </form>

            </article>
            <?php
                }
            }
            ?>
        </section>

        <section class="espaceAdmin_list boite">

            <?php if(isset($users)){ ?>
            <h2>Emplacement attribué <?= isset($emplacementCount) && isset($emplacementUsed) ? $emplacementUsed.'/'.$emplacementCount : '' ?> </h2>
            <?php
                foreach ($users as $index => $user){
                    // si admin -> skip
                    if ($index === 0) continue;
                    // si pas payé -> skip
                    if (!$user['a_paye']) continue;
                    // si emplacement pas attribué -> skip
                    if ($user['eid'] === null) continue;

                    $cleanedUserBid     = nettoyage_from_db($user['bid']);
                    $cleanedUserPrenom  = nettoyage_from_db($user['prenom']);
                    $cleanedUserNom     = nettoyage_from_db($user['nom']);
                    $cleanedUserPhoto   = nettoyage_from_db($user['photo']);

                    $currentCode = nettoyage_from_db($emplacementObject->getCodeById($user['eid']));
                    ?>

                    <article>
                        <div>
                            <img src="<?= $cleanedUserPhoto ?>" alt="<?= $cleanedUserPrenom . '_' . $cleanedUserNom . '_avatar' ?>">
                        </div>
                        <div>
                            <h3><?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?></h3>
                            <p>ID <?= $cleanedUserBid ?></p>
                            <p>Emplacement : <?= $currentCode ?></p>
                        </div>

                        <form action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="post">
                            <input type="hidden" name="userId" value="<?= $cleanedUserBid ?>">
                            <input type="hidden" name="username" value="<?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?>">
                            <input type="hidden" name="currentCode" value="<?= $currentCode ?>">

                            <label for="emplacements_<?= $cleanedUserBid ?>">Modifier :</label>
                            <select name="emplacements" id="emplacements_<?= $cleanedUserBid ?>" required>
                                <option value="">-- Sélectionnez un autre emplacement --</option>
                                <option value="removeEmplacement">Libérer l'emplacement</option>
                                <?php foreach ($emplacements as $emplacement) {?>
                                    <option value="<?= nettoyage_from_db($emplacement['code']) ?>"><?= nettoyage_from_db($emplacement['code']) ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" name="modif">Valider</button>

                        </form>
                        <form style="border-left: 0.2em solid #cccccc;padding : 0 0.8em;" action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="GET">
                            <p style="margin: 0.3em 0;">Supprimer brocanteur</p>
                            <input type="hidden" name="userId" value="<?= $cleanedUserBid ?>">
                            <input type="hidden" name="username" value="<?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?>">
                            <button type="submit" name="submit_delete" class="submit_delete">Supprimer</button>
                        </form>
                    </article>
                    <?php
                }
            }
            ?>

        </section>

        <section class="espaceAdmin_list boite">

            <?php if(isset($users)){ ?>
                <h2>En attente de paiement</h2>
                <?php
                foreach ($users as $index => $user){
                    // si admin -> skip
                    if ($index === 0) continue;
                    // si payé -> skip
                    if ($user['a_paye']) continue;

                    $cleanedUserBid     = nettoyage_from_db($user['bid']);
                    $cleanedUserPrenom  = nettoyage_from_db($user['prenom']);
                    $cleanedUserNom     = nettoyage_from_db($user['nom']);
                    $cleanedUserPhoto   = nettoyage_from_db($user['photo']);
                    ?>

                    <article>
                        <div>
                            <img src="<?= $cleanedUserPhoto ?>" alt="<?= $cleanedUserPrenom . '_' . $cleanedUserNom . '_avatar' ?>">
                        </div>
                        <div>
                            <h3><?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?></h3>
                            <p>ID <?= $cleanedUserBid ?></p>
                            <p>Emplacement : Non attribué</p>
                        </div>

                        <form style="border-left: 0.2em solid #cccccc;padding : 0 0.8em;" action="<?= nettoyage_from_db($_SERVER['PHP_SELF']) ?>" method="GET">
                            <p style="margin: 0.3em 0;">Supprimer brocanteur</p>
                            <input type="hidden" name="userId" value="<?= $cleanedUserBid ?>">
                            <input type="hidden" name="username" value="<?= $cleanedUserPrenom . ' ' . $cleanedUserNom ?>">
                            <button type="submit" name="submit_delete" class="submit_delete">Supprimer</button>
                        </form>
                    </article>
                    <?php
                }
            }
            ?>
        </section>

    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>
