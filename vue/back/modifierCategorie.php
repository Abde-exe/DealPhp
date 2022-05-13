<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";

if (!empty($_POST)) {
    if (
        isset($_POST["titre"]) &&
        isset($_POST["motscles"])
    ) {
        if (strlen($_POST["titre"])  < 1 || strlen($_POST["titre"]) > 255) {
            $error = true;
            $message = "Le titre doit avoir entre 1 et 255 caractères";
        }
        if (strlen($_POST["motscles"])  < 1) {
            $error = true;
            $message = "Veuillez entrer au moins un mot-clé";
        }
        $sql = "UPDATE categorie
                SET titre = :titre, motscles = :motscles
                WHERE id_categorie = :id_categorie ";

        $sth = $connexion->prepare($sql);
        $sth->execute([
            ":titre" => $_POST["titre"],
            ":motscles" => $_POST["motscles"],
            ":id_categorie" => $_POST["id_categorie"]
        ]);
        header("Location: index.php");
    }
} else {
    $error = true;
    $message = "Veuillez compléter tous les champs du formulaire pour créer une catégorie";
}

require_once 'vue/composants/header.php';
?>
<main>
    <div class="container">
        <h2 class="text-center mt-5">Modifier</h2>

        <form method="POST">
            <?php if ($error) : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif ?>
            <div class="mb-3">
                <input type="text" name="id_categorie" id="id_categorie" class="form-control" value="<?= htmlspecialchars($categorie["id_categorie"]) ?>" hidden>
            </div>
            <div class="mb-3">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control" value="<?= htmlspecialchars($categorie["titre"]) ?>">
            </div>
            <div class="mb-3">
                <label for="motscles">Mots-clés</label>
                <input type="text" name="motscles" id="motscles" class="form-control" value="<?= htmlspecialchars($categorie["motscle"]) ?>">
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>