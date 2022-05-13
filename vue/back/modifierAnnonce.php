<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";
if (!empty($_POST)) {
    if (
        isset($_POST["titre"]) &&
        isset($_POST["description_courte"]) &&
        isset($_POST["description_longue"]) &&
        isset($_POST["prix"]) &&
        isset($_POST["pays"]) &&
        isset($_POST["ville"]) &&
        isset($_POST["adresse"]) &&
        isset($_POST["cp"]) &&
        isset($_POST["membre_id"]) &&
        isset($_POST["photo"])

    ) {
        if (strlen($_POST["titre"])  < 1 || strlen($_POST["titre"]) > 255) {
            $error = true;
            $message = "Le titre doit avoir entre 1 et 255 caractères";
        }
        if (strlen($_POST["description_courte"])  < 1 || strlen($_POST["description_courte"]) > 255) {
            $error = true;
            $message = "La description courte doit avoir entre 1 et 255 caractères";
        }

        if (strlen($_POST["description_longue"])  < 1) {
            $error = true;
            $message = "La description longue doit avoir plus de 1 caractère";
        }

        if (!is_numeric($_POST["prix"])) {
            $error = true;
            $message = "Le prix doit être indiqué";
        }
        if (strlen($_POST["pays"])  < 1 || strlen($_POST["pays"]) > 20) {
            $error = true;
            $message = "Le pays doit avoir entre 1 et 20 caractères";
        }
        if (strlen($_POST["ville"])  < 1 || strlen($_POST["ville"]) > 20) {
            $error = true;
            $message = "La ville doit avoir entre 1 et 20 caractères";
        }
        if (strlen($_POST["adresse"])  < 1 || strlen($_POST["adresse"]) > 20) {
            $error = true;
            $message = "L'adresse doit avoir entre 1 et 50 caractères";
        }
        if (strlen($_POST["cp"])  < 5) {
            $error = true;
            $message = "Le code postal doit avoir 5 caractères";
        }


        $sql = "UPDATE annonce
                SET titre = :titre, description_courte = :description_courte, description_longue = :description_longue,
                prix = :prix,  pays = :pays, ville = :ville, adresse = :adresse,cp = :cp
                WHERE titre = :titre ";

        $sth = $connexion->prepare($sql);
        $sth->execute([
            ":titre" => $_POST["titre"],
            ":description_courte" => $_POST["description_courte"],
            ":prix" => $_POST["prix"],
            ":description_longue" => $_POST["description_longue"],
            ":pays" => $_POST["pays"],
            ":ville" => $ville,
            ":adresse" => $adresse,
            ":cp" => $cp,

        ]);
        header("Location: index.php");
    } else {
        $error = true;
        $message = "Veuillez compléter tous les champs du formulaire pour modifier une annonce";
    }
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
            <input type="text" name="id_annonce" id="id_annonce" class="form-control" value="<?= htmlspecialchars($annonce["id_annonce"]) ?>" hidden>
            <div class="mb-3">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control">
            </div>
            <div class="mb-3">
                <label for="photo">Photo(URL)</label>
                <!-- <input type="file" name="photo" id="photo"> -->
                <input type="text" name="photo" id="photo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description_courte">Description courte</label>
                <input type="text" name="description_courte" id="description_courte" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description_longue">Description longue</label>
                <textarea rows="10" name="description_longue" id="description_longue" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="prix">Prix</label>
                <input type="number" name="prix" id="prix" class="form-control">
            </div>
            <div class="mb-3">
                <label for="ville">Ville</label>
                <input type="text" name="ville" id="ville" class="form-control">
            </div>
            <div class="mb-3">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="form-control">
            </div>
            <div class="mb-3">
                <label for="cp">Code Postal</label>
                <input type="number" name="cp" id="cp" class="form-control">
            </div>

            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>