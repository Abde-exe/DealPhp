<?php

// $_SESSION est une superglobale, donc un tableau array
// Cette superglobale n'existe pas par défaut
// Une ouverture de session va créer un cookie sur le navigateur utilisateur ainsi qu'un fichier de session sur le serveur

// Pour lancer une session :
session_start(); // permet de créer un fichier de session OU de l'ouvrir s'il existe déjà

// Pour voir le fichier de session : aller dans le dossier tmp ou temp de votre serveur
// La session étant liée à un cookie, c'est ce qui vous identifie avant la connexion (identification) utilisateur

// La session étant un tableau array, on peut y placer les informations que l'on souhaite :
echo '<b>Premier affichage de la session : </b><hr>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';


$_SESSION['membre']['pseudo'] = 'admin';
$_SESSION['membre']['mdp'] = 'soleil';
$_SESSION['membre']['email'] = 'admin@mail.fr';
$_SESSION['membre']['adresse'] = 'rue de la terre';
$_SESSION['membre']['cp'] = '75000';
$_SESSION['membre']['ville'] = 'Paris';



// Pour enlever un élément d'un tableau array
unset($_SESSION['mdp']);

echo '<b>Deuxième affichage de la session : </b><hr>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Pour supprimer un fichier de session
// session_destroy();

echo '<b>Troisième affichage de la session : </b><hr>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// La session est encore visible alors que l'on a exécuté un session_destroy() avant
// Normal ! PHP reconnait l'instruction mais ne l'exéctuera qu'après toutes les lignes de code de cette page exécutées