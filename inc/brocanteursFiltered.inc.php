<?php
if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}
?>

<article>
    <div>
        <img src="<?= nettoyage_from_db($brocanteur['photo']) ?>" alt="<?= nettoyage_from_db($brocanteur['prenom']) . '_' . nettoyage_from_db($brocanteur['nom']) . '_avatar' ?>">
    </div>
    <div>
        <h3><?= nettoyage_from_db($brocanteur['prenom']) . ' ' . nettoyage_from_db($brocanteur['nom']) ?></h3>
        <p>Emplacement <?= nettoyage_from_db($brocanteur['code']) . ' - ' . nettoyage_from_db($brocanteur['zone']) ?></p>
<!--        <p>XX objets en ventes</p>-->
    </div>
    <div>
        <a href="brocanteur.php?bid=<?= $brocanteur['bid'] ?>">Voir</a>
    </div>
</article>
