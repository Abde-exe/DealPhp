<?php
require 'lib/tableau.php';
require_once 'vue/composants/header.php';
$attributs = ['id_annonce', 'titre', 'description_courte', 'description_courte', 'prix', 'photo',  'pays', 'ville', 'cp', 'date_enregistrement'];

?>
<h2 class="text-center mt-5 mb-5">Toutes les annonces</h2>

<?= genererTableau($connexion, 'annonce', $attributs) ?>
<h2 class="text-center mt-5 mb-5">Ajouter une annonce</h2>

<?php require 'vue/composants/formAnnonce.php' ?>

<?php
require_once 'vue/composants/footer.php';

?>