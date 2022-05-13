<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";
if (!empty($_POST)) {
    if (
        isset($_POST["nom"]) &&
        isset($_POST["prenom"]) &&
        isset($_POST["pseudo"]) &&
        isset($_POST["email"]) &&
        isset($_POST["mdp"]) &&
        isset($_POST["telephone"]) &&
        ($_POST["civilite"] == "m" || $_POST["civilite"] == "f") &&
        ($_POST["statut"] == 0 || $_POST["statut"] == 1)
    ) {
        if (strlen($_POST["nom"])  < 1 || strlen($_POST["nom"]) > 20) {
            $error = true;
            $message = "Le nom doit avoir entre 1 et 20 caractères";
        }
        if (strlen($_POST["prenom"])  < 1 || strlen($_POST["prenom"]) > 20) {
            $error = true;
            $message = "Le prenom doit avoir entre 1 et 20 caractères";
        }
        if (strlen($_POST["pseudo"])  < 1 || strlen($_POST["pseudo"]) > 20) {
            $error = true;
            $message = "Le pseudo doit avoir entre 1 et 20 caractères";
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"])  < 1 || strlen($_POST["email"]) > 50) {
            $error = true;
            $message = "L'email doit avoir entre 1 et 50 caractères et être au format email";
        }
        if (strlen($_POST["mdp"])  < 1 || strlen($_POST["mdp"]) > 60) {
            $error = true;
            $message = "Le mot de passe doit avoir entre 1 et 60 caractères";
        }
        if (strlen($_POST["telephone"])  != 10 || !is_numeric($_POST["telephone"])) {
            $error = true;
            $message = "Le numéro de tél. doit être composé uniquement de 10 chiffres";
        } else {
            $sql = "SELECT * FROM membre WHERE pseudo ='{$_POST['pseudo']}' ";
            $nbLigne = $connexion->prepare($sql);
            $nbLigne->execute();
            $doublon = $nbLigne->fetchColumn();
            if ($doublon == 0) {
                $sql = "INSERT INTO membre
                (nom,prenom, pseudo,email,mdp, telephone,  civilite, statut,date_enregistrement)
                VALUES
                (:nom,:prenom, :pseudo,:email,:mdp, :telephone, :civilite, :statut, curDate())";

                $sth = $connexion->prepare($sql);
                $sth->execute([
                    ":nom" => $_POST["nom"],
                    ":prenom" => $_POST["prenom"],
                    ":pseudo" => $_POST["pseudo"],
                    ":mdp" => password_hash($_POST["mdp"], PASSWORD_DEFAULT),
                    ":telephone" => $_POST["telephone"],
                    ":email" => $_POST["email"],
                    ":civilite" => $_POST["civilite"],
                    ":statut" => $_POST["statut"],
                ]);
                header("Location: index.php?connexion");
            } else {
                $error = true;
                $message = "Ce pseudo existe déjà veuillez en choisir un autre";
            }
        }
    } else {
        $error = true;
        $message = "Veuillez compléter tous les champs du formulaire pour créer un profil";
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
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control">
            </div>
            <div class="mb-3">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="mail" name="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="form-control">
            </div>
            <div class="mb-3">
                <label for="telephone">Téléphone</label>
                <input type="tel" maxlength="10" name="telephone" id="telephone" class="form-control">
            </div>
            <div class="mb-3">
                <label for="civilite">Civilité</label>
                <select name="civilite" id="civilite" class="form-select">
                    <option value="m">M</option>
                    <option value="f">F</option>
                </select>
            </div>
            <div class="mb-3" hidden>
                <label for="statut">Statut</label>
                <select name="statut" id="statut" class="form-select">
                    <option value="1">Admin</option>
                    <option value="0" selected>Membre</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>