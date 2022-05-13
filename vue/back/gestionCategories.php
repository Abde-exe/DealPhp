<?php
require 'lib/tableau.php';
require_once 'vue/composants/header.php';
$attributs = ['id_categorie', 'titre', 'motscles',];
?>
<h2 class="text-center mt-5 mb-5">Toutes les catégories</h2>
<?= genererTableau($connexion, 'categorie', $attributs) ?>
<h2 class="text-center mt-5 mb-5">Ajouter une catégorie</h2>
<?php require 'vue/composants/formCategorie.php' ?>
<?php
require_once 'vue/composants/footer.php';
?>