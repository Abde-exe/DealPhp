<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";

if (!empty($_POST)) {
    var_dump($_POST);
    if (
        isset($_POST["commentaire"])
    ) {
        if (strlen($_POST["commentaire"])  < 1 || strlen($_POST["commentaire"]) > 255) {
            $error = true;
            $message = "Le commentaire doit avoir entre 1 et 255 caractères";
        }
        $sql = "INSERT INTO categorie
                (membre_id,annonce_id,commentaire,date_enregistrement)
                VALUES
                (:membre_id,:annonce_id,:commentaire, curDate())";

        $sth = $connexion->prepare($sql);
        $sth->execute([
            ":membre_id" => $_SESSION["membre"]["id_membre"],
            ":annonce_id" => $annonce["id_annonce"],
            ":commentaire" => $_POST[":commentaire"],
        ]);
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
            <input type="text" name="membre_id" id="membre_id" hidden value="<?= $membre['id_membre'] ?>">
            <input type="text" name="annonce_id" id="annonce_id" hidden value="<?= $annonce['id_annonce'] ?>">
            <div class=" mb-3">
                <label for="commentaire">Votre commentaire</label>
                <textarea type="text" name="commentaire" cols="30" rows="5" id="commentaire" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>