<?php
require_once 'vue/composants/header.php';

$sqlmem = "SELECT * from membre WHERE id_membre = '{$annonce['membre_id']}'";
$membre  = $connexion->query($sqlmem)->fetch();

$sqlcat = "SELECT titre from categorie WHERE id_categorie = '{$annonce['categorie_id']}'";
$categorie =  $connexion->query($sqlcat)->fetch();

$sqlcom = "SELECT * from commentaire WHERE annonce_id = '{$annonce['id_annonce']}'";
$commentaires =  $connexion->query($sqlcom)->fetchAll();

$sqlnot = "SELECT * from note WHERE membre_id2 = '{$annonce['membre_id']}'";
$notes =  $connexion->query($sqlnot)->fetchAll();
$message = "";


?>
<div class="container">
    <h2 class="text-center mt-5 mb-5"><?= $annonce["titre"] ?></h2>
    <div class="container row">
        <img src="<?= $annonce["photo"] ?>" class="img-fluid col-6">
        <div class="col-6">
            <h3>Description</h3>
            <p><?= $annonce["description_longue"] ?></p>
            <a href=""><?= $categorie["titre"] ?></a>
        </div>
    </div>
    <div class="container d-flex justify-content-evenly mt-5 mb-5">
        <small> <i class="fa-solid fa-calendar"></i> Date de publication : <?= date('d/m/Y', strtotime($annonce["date_enregistrement"])) ?></small>
        <small> <i class="fa-solid fa-euro-sign"></i> <?= $annonce["prix"] ?></small>
        <small> <i class="fa-solid fa-user"></i> <a href="?profil&id=<?= $membre["id_membre"] ?>"> <?= $membre["pseudo"] ?> </a> </small>
        <small> <i class="fa-solid fa-location-dot"></i> <?= $annonce["adresse"] . ', ' . $annonce["cp"] . ', ' . $annonce["ville"] ?> </small>
    </div>
    <hr class="mb-5">

    <!-- notes -->
    <div class="container row">
        <h3>Notes</h3>
        <?php foreach ($notes as $note) : ?>
            <!-- on recupere l auteur de la note -->
            <?php $auteurNot =  $connexion->query("SELECT pseudo,id_membre from membre WHERE id_membre = '{$note['membre_id2']}'")->fetch();
            ?>
            <div class="container col-4  p-3 bg-light">
                <span style="font-size: 2em; color: gold;">
                    <i class="fa-solid fa-star"></i><?= $note['note'] ?>
                </span>


                <i class="fa-solid fa-user"></i> <a href="?profil&id=<?= $auteurNot['id_membre'] ?>"><?= $auteurNot["pseudo"] ?></a>
                <small><?= date('d/m/Y', strtotime($note["date_enregistrement"])) ?></small>
                <p><?= $note["avis"] ?></p>

            </div>
        <?php endforeach ?>
        <?php isset($_SESSION["membre"]) ? require 'vue/composants/formNote.php' : $message = "<a class=\"mb-5\" href=\"?connexion\">Connectez-vous pour poster un avis ou un commentaire </a>"; ?>



        <!-- commentaire -->
        <div class="container mb-3 mt-5">
            <h3>Commentaires</h3>
            <?php foreach ($commentaires as $commentaire) : ?>
                <!-- on recupere l auteur du commentaire -->
                <?php $auteurCom =  $connexion->query("SELECT pseudo,id_membre from membre WHERE id_membre = '{$commentaire['membre_id']}'")->fetch();
                ?>
                <div class="container m-3 p-3 bg-light">
                    <i class="fa-solid fa-user"></i> <a href="?profil&id=<?= $auteurCom['id_membre'] ?>"><?= $auteurCom["pseudo"] ?></a>
                    <small><?= date('d/m/Y', strtotime($commentaire["date_enregistrement"])) ?></small>
                    <p><?= $commentaire["commentaire"] ?></p>

                </div>
            <?php endforeach ?>
            <?php isset($_SESSION["membre"]) ?  require 'vue/composants/formCommentaire.php' : ""; ?>




        </div>

    </div>

    <?= $message ?>

    <?php
    require_once 'vue/composants/footer.php';

    ?>