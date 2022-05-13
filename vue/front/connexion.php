<?php
require 'lib/connexionbdd.php';
$error = false;
$message = "";
if (!empty($_POST)) {
    if (
        isset($_POST["pseudo"]) && strlen($_POST["pseudo"])  > 1 &&
        isset($_POST["mdp"]) && strlen($_POST["mdp"])  > 1
    ) {
        $sql = "SELECT * from membre WHERE pseudo= '{$_POST['pseudo']}'";
        $membre  = $connexion->query($sql)->fetch();

        if (!$membre) {
            //utilisateur inexistant
            $error = true;
            $message = "Utilisateur introuvable";
        } elseif (password_verify($_POST["mdp"], $membre["mdp"])) {
            //connexion réussie
            $attributs = ['id_membre', 'nom', 'prenom', 'pseudo', 'email', 'telephone', 'civilite', 'date_enregistrement'];

            $sql = "SELECT * FROM membre WHERE pseudo = '{$_POST['pseudo']}' ";
            $membre = $connexion->query($sql)->fetch();


            //session
            foreach ($attributs as $att) {
                $_SESSION['membre'][$att] = $membre[$att];
            }
            $_SESSION['membre']['statut'] = (int)$membre['statut'];
            var_dump((int)$membre['statut']);
            header('Location: index.php');
            die();
        } else {
            //verification mdp
            var_dump($membre["mdp"]);
            var_dump($_POST["mdp"]);

            $error = true;
            $message = "Mot de passe incorrect";
        }
    } else {
        $error = true;
        $message = "Remplir tous les champs pour se connecter";
    }
}

?>
<?php
require_once 'vue/composants/header.php';

?>
<main>
    <div class="container">
        <h2 class="text-center mt-5">Connexion</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" maxlength="250">
            </div>
            <div class="mb-3">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="form-control" maxlength="60">
                <div class="mt-3">
                    <input type="submit" value="Valider" class="btn btn-primary">
                </div>
                <?php if ($error) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif ?>
        </form>

    </div>
    <a class="mb-5" href="?inscription">S'inscrire</a>
</main>
<?php
require_once 'vue/composants/footer.php';

?>