<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";
if (!empty($_POST)) {
    var_dump($_POST);
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
        } else {
            $sql = "SELECT * FROM categorie WHERE titre ='{$_POST['titre']}' ";
            $nbLigne = $connexion->prepare($sql);
            $nbLigne->execute();
            $doublon = $nbLigne->fetchColumn();

            if ($doublon == 0) {
                $sql = "INSERT INTO categorie
                (titre,motscles)
                VALUES
                (:titre,:motscles)";

                $sth = $connexion->prepare($sql);
                $sth->execute([
                    ":titre" => $_POST["titre"],
                    ":motscles" => $_POST["motscles"]
                ]);
            } else {
                $error = true;
                $message = "Ce titre existe déjà veuillez en choisir un autre";
            }
        }
    } else {
        $error = true;
        $message = "Veuillez compléter tous les champs du formulaire pour créer une catégorie";
    }
}


?>
<main>
    <div class="container">
        <form method="POST">
            <?php if ($error) : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif ?>
            <div class="mb-3">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control">
            </div>
            <div class="mb-3">
                <label for="motscles">Mots-clés</label>
                <input type="text" name="motscles" id="motscles" class="form-control">
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>