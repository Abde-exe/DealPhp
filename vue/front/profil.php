<?php
require_once 'vue/composants/header.php';

?>
<main>
    <div class="container">
        <h2 class="text-center mt-5">Profil</h2>
        <p><span>Nom :</span> <?= htmlspecialchars($membre["nom"]) ?></p>
        <p><span>Prénom :</span> <?= htmlspecialchars($membre["prenom"]) ?></p>
        <p><span>Pseudo :</span> <?= htmlspecialchars($membre["pseudo"]) ?></p>
        <p><span>Email :</span> <?= htmlspecialchars($membre["email"]) ?></p>
        <p><span>Téléphone :</span> <?= htmlspecialchars($membre["telephone"]) ?></p>
        <p><span>Civilité :</span> <?= htmlspecialchars($membre["civilite"]) ?></p>

        <a href="?modifier&type=membre&id=<?= $membre['id_membre'] ?>" class="btn btn-secondary">Modifier</a>

    </div>
</main>
<?php
require_once 'vue/composants/footer.php';

?>