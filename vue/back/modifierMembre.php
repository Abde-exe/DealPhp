<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";
if (!empty($_POST)) {
    if (
        isset($_POST["nom"]) &&
        isset($_POST["prenom"]) &&
        isset($_POST["email"]) &&
        isset($_POST["telephone"]) &&
        ($_POST["civilite"] == "m" || $_POST["civilite"] == "f") &&
        ($_POST["statut"] == 0 || $_POST["statut"] == 1)
    ) {
        var_dump($_POST);
        if (strlen($_POST["nom"])  < 1 || strlen($_POST["nom"]) > 20) {
            $error = true;
            $message = "Le nom doit avoir entre 1 et 20 caractères";
        }
        if (strlen($_POST["prenom"])  < 1 || strlen($_POST["prenom"]) > 20) {
            $error = true;
            $message = "Le prenom doit avoir entre 1 et 20 caractères";
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"])  < 1 || strlen($_POST["email"]) > 50) {
            $error = true;
            $message = "L'email doit avoir entre 1 et 50 caractères et être au format email";
        }
        if (
            !empty(($_POST["mdp"])) && (strlen($_POST["mdp"])  < 1 || strlen($_POST["mdp"]) > 60)
        ) {
            $error = true;
            $message = "Le mot de passe doit avoir entre 1 et 60 caractères";
        }
        if (strlen($_POST["telephone"])  != 10 || !is_numeric($_POST["telephone"])) {
            $error = true;
            $message = "Le numéro de tél. doit être composé uniquement de 10 chiffres";
        } else {
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
            if (empty($_POST["mdp"])) { //si aucun nouveau mdp est saisi on remet le mdp deja stocke en bdd
                $mdp = $connexion->query("SELECT mdp FROM membre WHERE id_membre ='{$_POST['id_membre']}' ")->fetch();
                $mdp = $mdp["mdp"];
            }



            $sql = "UPDATE membre
                SET nom = :nom, prenom = :prenom, email = :email, mdp = :mdp, telephone = :telephone,  civilite = :civilite
                WHERE id_membre = :id_membre ";

            $sth = $connexion->prepare($sql);
            $sth->execute([
                ":nom" => $_POST["nom"],
                ":prenom" => $_POST["prenom"],
                ":mdp" => $mdp,
                ":telephone" => $_POST["telephone"],
                ":email" => $_POST["email"],
                ":civilite" => $_POST["civilite"],
                ":id_membre" => $_POST["id_membre"]

            ]);
            //modification des donnees de la session
            $attributs = ['nom', 'prenom', 'email', 'telephone', 'civilite',];

            foreach ($attributs as $att) {
                $_SESSION['membre'][$att] = $_POST[$att];
            }
            header("Location: index.php");
        }
    } else {
        $error = true;
        $message = "Veuillez compléter tous les champs du formulaire pour modifier un profil";
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
            <input type="text" name="id_membre" id="id_membre" class="form-control" value="<?= htmlspecialchars($membre["id_membre"]) ?>" hidden>
            <div class="mb-3">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($membre["nom"]) ?>">
            </div>
            <div class="mb-3">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="<?= htmlspecialchars($membre["prenom"]) ?>">
            </div>
            <div class="mb-3">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= htmlspecialchars($membre["pseudo"]) ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="mail" name="email" id="email" class="form-control" value="<?= htmlspecialchars($membre["email"]) ?>">
            </div>
            <div class="mb-3">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="form-control">
            </div>
            <div class="mb-3">
                <label for="telephone">Téléphone</label>
                <input type="tel" maxlength="10" name="telephone" id="telephone" class="form-control" value="<?= htmlspecialchars($membre["telephone"]) ?>">
            </div>
            <div class="mb-3">
                <label for="civilite">Civilité</label>
                <select name="civilite" id="civilite" class="form-select" value="<?= htmlspecialchars($membre["civilite"]) ?>">
                    <option value="m">M</option>
                    <option value="f">F</option>
                </select>
            </div>
            <div <?= $_SESSION["membre"]["statut"] == 1 ? "" : "hidden" ?> class="mb-3">
                <label for="statut">Statut</label>
                <select name="statut" id="statut" class="form-select">
                    <option value="1">Admin</option>
                    <option value="0">Membre</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="btn btn-primary">
            </div>
        </form>

    </div>
</main>