<?php const SAFE_ENTRY = true; require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/controller.objet.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php $title = "Objet"; include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/head.inc.php'; ?>
<body>
    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/header.inc.php'; ?>

    <main id="Objet" class="max-width">

        <?php if(isset($errorMessage)){ ?>
            <section class="boite">
                <?= $errorMessage ?>
            </section>
        <?php } else { ?>

        <section id="ObjetProfil" class="boite">
            <div>
                <img src="<?php if(isset($image)){ echo $image;} ?>" alt="<?php if(isset($intitule)){ echo $intitule;} ?>">
            </div>

            <div>
                <h1><?php if(isset($intitule)){ echo $intitule;} ?></h1>
                <p>Vendeur : <?php if(isset($userFullName)){ echo $userFullName;} ?></p>
                <p>Emplacement : <?php if(isset($codeEmplacement)){ echo $codeEmplacement;} ?></p>
                <p>Zone : <?= $zone ?></p>
                <p>Code : ID <?php if(isset($oid)){ echo $oid;} ?></p>
                <p>Catégorie : <?php if(isset($categorie)){ echo $categorie;} ?></p>
                <p style="text-align: justify">Description : <?php if(isset($description)){ echo $description;} ?></p>
            </div>
        </section>
    <?php } ?>
    </main>

    <?php include_once dirname($_SERVER['DOCUMENT_ROOT']) . '/inc/footer.inc.php'; ?>

</body>
</html>