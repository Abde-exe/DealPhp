<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";

if (!empty($_POST)) {
    var_dump($_POST);
    if (
        isset($_POST["avis"]) &&
        isset($_POST["motscles"])
    ) {
        if (strlen($_POST["avis"])  < 1 || strlen($_POST["avis"]) > 255) {
            $error = true;
            $message = "L'avis doit avoir entre 1 et 255 caractères";
        }
        if (strlen($_POST["motscles"])  < 1) {
            $error = true;
            $message = "Veuillez entrer au moins un mot-clé";
        } else {
            $sql = "SELECT * FROM categorie WHERE avis ='{$_POST['avis']}' ";
            $nbLigne = $connexion->prepare($sql);
            $nbLigne->execute();
            $doublon = $nbLigne->fetchColumn();

            if ($doublon == 0) {
                $sql = "INSERT INTO categorie
                (avis,motscles)
                VALUES
                (:avis,:motscles)";

                $sth = $connexion->prepare($sql);
                $sth->execute([
                    ":avis" => $_POST["avis"],
                    ":motscles" => $_POST["motscles"]
                ]);
            } else {
                $error = true;
                $message = "Ce avis existe déjà veuillez en choisir un autre";
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
        <form method="post">
            <input type="text" name="membre_id1" id="membre_id1" hidden value="<?= $_SESSION['membre']['id_membre'] ?>">
            <input type="text" name="membre_id2" id="membre_id2" hidden value="<?= $membre['id_membre'] ?>">

            <div class="mb-3">
                <label for="note">Votre note</label>
                <select name="note" id="note" class="form-select">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="avis">Votre avis</label>
                <textarea name="avis" id="avis" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>
        <hr>
    </div>
</main>