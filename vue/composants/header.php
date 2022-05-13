<?php
$connecte = false;
$admin = false;

if ($_SESSION) {
    $connecte = true;
    if ($_SESSION['membre']['statut'] == 1) $admin = true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Deal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a0e3cca62c.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>

        <div>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand">Deal</a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link">Accueil</a>
                            </li>
                            <li class="nav-item" <?= $admin ? '' : 'hidden' ?>>
                                <a href="?membres" class="nav-link">Membres</a>
                            </li>
                            <li class="nav-item" <?= $admin ? '' : 'hidden' ?>>
                                <a href="?annonces" class="nav-link">Annonces</a>
                            </li>
                            <li class="nav-item" <?= $admin ? '' : 'hidden' ?>>
                                <a href="?categories" class="nav-link">Catégories</a>
                            </li>
                            <li class="nav-item" <?= $admin ? '' : 'hidden' ?>>
                                <a href="?notes" class="nav-link">Notes</a>
                            </li>
                            <li class="nav-item" <?= $admin ? '' : 'hidden' ?>>
                                <a href="?commentaires" class="nav-link">Commentaires</a>
                            </li>

                        </ul>
                        <ul class="nav navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <i class="fa-solid fa-user"></i>
                                    Espace membre</a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="?connexion" class="dropdown-item" <?= $connecte ? "hidden" : "" ?>> Connexion</a>
                                    <a href="?inscription" class="dropdown-item" <?= $connecte ? "hidden" : "" ?>> Inscription</a>
                                    <a href="?profil&id=<?= $_SESSION['membre']['id_membre'] ?>" class="dropdown-item" <?= $connecte ? "" : "hidden" ?>>Profil</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="index.php?deconnexion" class="dropdown-item" <?= $connecte ? "" : "hidden" ?>>Déconnexion</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>