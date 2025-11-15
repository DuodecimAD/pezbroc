<?php
if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}
?>

<article <?php if(basename($_SERVER['PHP_SELF']) === "index.php"){ echo 'class="boite"'; }?>>
    <img src="<?= nettoyage_from_db($eachObjet['image']) ?>" alt="<?= nettoyage_from_db($eachObjet['intitule']) ?>">
    <h3><?= nettoyage_from_db($eachObjet['intitule']) ?></h3>

    <?php if(basename($_SERVER['PHP_SELF']) === "espaceBrocanteur.php"){ ?>
        <a href="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>?modif&oid=<?= nettoyage_from_db($eachObjet['oid']) ?>#scrollHere">Modifier</a>
        <a href="<?= nettoyage_to_db($_SERVER['PHP_SELF']) ?>?del&oid=<?= nettoyage_from_db($eachObjet['oid']) ?>#scrollHere" class="submit_delete delete_icon">
            <img src="images/icon_trash.svg" alt="corbeille icon to delete objet">
        </a>
    <?php } else { ?>
        <a href="objet.php?oid=<?= nettoyage_from_db($eachObjet['oid']) ?>">Voir</a>
    <?php } ?>

</article>

