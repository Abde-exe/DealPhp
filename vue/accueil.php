<?php
require_once 'vue/composants/header.php';
?>

<!-- main -->
<main>
    <h2 class="text-center mt-5 mb-5">Annonces</h2>
    <div class="d-flex justify-content-center gap-5">

        <?php foreach ($annonces as $annonce) : ?>
            <div class="card" style="width: 18rem;">
                <img src="<?= $annonce["photo"] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($annonce["titre"]) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($annonce["description_courte"]) ?></p>
                    <div class="d-flex justify-content-between">

                        <a href="?annonce&id=<?= htmlspecialchars($annonce["id_annonce"]) ?>" class="btn btn-primary">Voir plus</a>
                        <h3><?= htmlspecialchars($annonce["prix"]) ?> €</h3>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="container mt-5">
        <a class="btn btn-primary" href="<?= isset($_SESSION["membre"]) ? "?ajouter" : "?connexion" ?>">Créer une annonce</a>
    </div>
</main>

<?php
require_once 'vue/composants/footer.php';

?>