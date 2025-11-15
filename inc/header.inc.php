<?php
if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}
?>

<?php
if (!isset($_SESSION['user']['loggedIn']) || !$_SESSION['user']['loggedIn']) {
    echo '<a href="login.php" id="loginButton">Me connecter</a>';
} else {
?>
    <div id="loggedin">
        <div id="userInfos">
            <img src="<?php echo $_SESSION['user']['photo']; ?>" alt="photo">

            <?php if($_SESSION['user']['est_administrateur'] === false) { ?>
                <a href="espaceBrocanteur.php"><?= $_SESSION['user']['courriel'] ?></a>
            <?php } else { ?>
                <a href="espaceAdmin.php"><?= $_SESSION['user']['courriel'] ?></a>
            <?php } ?>
        </div>

        <a href="logout.php">Me déconnecter</a>
    </div>

<?php } ?>

<header id="headerPage">
    <a href="index.php" class="revert"><img src="images/logo.svg" alt="PEZBroc" ></a>
</header>

<nav>
    <ul>
        <li><a href="index.php" <?php if($title == "Accueil") { ?> class="active" <?php } ?>>Accueil</a></li>
        <li><a href="contact.php" <?php if($title == "Contact") { ?>  class="active" <?php } ?>>Contact</a></li>
        <li><a href="brocanteurs.php" <?php if($title == "Brocanteurs") { ?>  class="active" <?php } ?>>Brocanteurs</a></li>
        <li><a href="objets.php" <?php if($title == "Objets") { ?>  class="active" <?php } ?>>Objets</a></li>

        <?php if(!isset($_SESSION['user'])) { ?>
        <li><a href="inscription.php" <?php if($title == "Inscription") { ?>  class="active" <?php } ?>>M'inscrire</a></li>
        <?php } else {
            if($_SESSION['user']['est_administrateur'] === false) { ?>
                <li><a href="espaceBrocanteur.php"<?php if($title == "Espace Brocanteur") { ?>  class="active" <?php } ?>>Mon Espace</a></li>
            <?php } else { ?>
                <li><a href="espaceAdmin.php"<?php if($title == "Espace Administrateur") { ?>  class="active" <?php } ?>>Mon Espace</a></li>
            <?php }
        } ?>
    </ul>
</nav>
