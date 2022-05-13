<?php
require 'lib/tableau.php';
require_once 'vue/composants/header.php';
$attributs = ['id_membre', 'nom', 'prenom', 'pseudo', 'email', 'telephone',  'civilite', 'statut', 'date_enregistrement'];
?>
<h2 class="text-center mt-5 mb-5">Tous les membres </h2>
<?= genererTableau($connexion, 'membre', $attributs) ?>
<h2 class="text-center mt-5 mb-5">Ajouter un membre</h2>
<?php require 'vue/composants/formMembre.php' ?>
<?php
require_once 'vue/composants/footer.php';
?>