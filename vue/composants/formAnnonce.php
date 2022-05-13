<?php
require 'lib/connexionbdd.php';
$membre = $_SESSION["membre"];
$error = false;
$message = "";
$sql = "SELECT titre, id_categorie from categorie";
$categories  = $connexion->query($sql)->fetchAll();

if (!empty($_POST)) {
    if (
        isset($_POST["titre"]) &&
        isset($_POST["categorie_id"]) &&
        isset($_POST["membre_id"]) &&
        isset($_POST["photo"]) &&
        isset($_POST["description_courte"]) &&
        isset($_POST["description_longue"]) &&
        isset($_POST["prix"]) &&
        isset($_POST["pays"]) &&
        isset($_POST["ville"]) &&
        isset($_POST["adresse"]) &&
        isset($_POST["cp"])

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
        } else {
            var_dump($_POST);
            $sql = "SELECT * FROM annonce WHERE titre ='{$_POST['titre']}' ";
            $nbLigne = $connexion->prepare($sql);
            $nbLigne->execute();
            $doublon = $nbLigne->fetchColumn();
            if ($doublon == 0) {
                $sql = "INSERT INTO annonce
                (titre,categorie_id,membre_id,photo,description_courte, description_longue,prix,  pays, ville,adresse, cp, date_enregistrement)
                VALUES
                (:titre,:categorie_id,:membre_id,:photo,:description_courte, :description_longue,:prix, :pays,:ville,:adresse,:cp , curDate())";

                $sth = $connexion->prepare($sql);
                $sth->execute([
                    ":titre" => $_POST["titre"],
                    ":categorie_id" => $_POST["categorie_id"],
                    ":membre_id" => $_POST["membre_id"],
                    ":photo" => $_POST["photo"],
                    ":description_courte" => $_POST["description_courte"],
                    ":description_longue" => $_POST["description_longue"],
                    ":prix" => $_POST["prix"],
                    ":pays" => $_POST["pays"],
                    ":ville" => $_POST["ville"],
                    ":adresse" => $_POST["adresse"],
                    ":cp" => $_POST["cp"],

                ]);
                //header("Location: index.php");
            }
        }
    } else {
        $error = true;
        $message = "Veuillez compléter tous les champs du formulaire pour modifier une annonce";
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
            <div class="mb-3" hidden>
                <input type="text" name="membre_id" id="membre_id" value="<?= $_SESSION["membre"]["id_membre"] ?>">
            </div>
            <div class="mb-3">
                <label for="categorie_id">Catégorie</label>
                <select name="categorie_id" id="categorie_id" class="form-select">
                    <?php foreach ($categories as $cate) : ?>
                        <option value="<?= $cate["id_categorie"] ?>"><?= $cate["titre"] ?></option>
                    <?php endforeach ?>
                </select>
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
                <label for="pays">Pays</label>
                <input type="text" name="pays" id="pays" class="form-control">
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
                <input maxlength="5" type="number" name="cp" id="cp" class="form-control">
            </div>

            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>