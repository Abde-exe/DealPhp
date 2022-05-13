<?php
require 'lib/tableau.php';
require_once 'vue/composants/header.php';
$attributs = ['id_commentaire', 'membre_id', 'annonce_id', 'commentaire', 'date_enregistrement'];

?>
<h2 class="text-center mt-5 mb-5">Tous commentaires</h2>
<?= genererTableau($connexion, 'commentaire', $attributs) ?>
/h2>
<?php require 'vue/composants/formCommentaire.php' ?>
<?php
require_once 'vue/composants/footer.php';
?>