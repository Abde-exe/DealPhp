<?php
require 'lib/tableau.php';
require_once 'vue/composants/header.php';
$attributs = ['id_note', 'membre_id1', 'membre_id2', 'note', 'avis', 'date_enregistrement'];

?>
<h2 class="text-center mt-5 mb-5">Toutes les notes</h2>
<?= genererTableau($connexion, 'note', $attributs) ?>

<?php
require_once 'vue/composants/footer.php';
?>