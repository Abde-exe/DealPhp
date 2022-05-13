<?php
require 'lib/connexionbdd.php';
session_start();

//accueil
if (empty($_GET)) {
    $sql = "SELECT * FROM annonce";
    $annonces  = $connexion->query($sql)->fetchAll();
    require 'vue/accueil.php';
    die();
}
// ----------- front office -----------------
if (isset($_GET["inscription"])) {
    require 'vue/back/creerMembre.php';
    die();
}
if (isset($_GET["connexion"])) {
    require 'vue/front/connexion.php';
    die();
}
//page profil
if (isset($_GET["profil"]) && isset($_GET["id"])) {
    $sql = "SELECT * FROM membre WHERE id_membre= {$_GET['id']}";
    $membre  = $connexion->query($sql)->fetch();
    require 'vue/front/profil.php';

    die();
}

//creer une annonce
if (isset($_GET["ajouter"])) {
    require 'vue/back/creerAnnonce.php';
}
// afficher une annonce
if (
    isset($_GET["annonce"]) && isset($_GET["id"])
) {
    $sql = "SELECT * FROM annonce WHERE id_annonce = {$_GET['id']}";
    $annonce  = $connexion->query($sql)->fetch();
    require 'vue/front/ficheAnnonce.php';
}

if (isset($_GET["deconnexion"])) {
    $_SESSION = array();
    session_destroy();
    header('Location: index.php');
    die();
}

// ----------- back office -----------------


//afficher membres
if (isset($_GET["membres"])) {
    if (!empty($_SESSION)) {
        if ($_SESSION["membre"]["statut"] == 1) {

            $sql = "SELECT * FROM membre";
            $membres  = $connexion->query($sql)->fetchAll();
            require 'vue/back/gestionMembres.php';
        } else {
            echo 'Accès non autorisé, il faut être admin';
        }
    } else {
        header('Location: index.php?connexion');
    }
    die();
}


//modifier membre
if (isset($_GET["modifier"]) && isset($_GET["id"]) && $_GET["type"] == "membre") {
    $sql = "SELECT * FROM membre WHERE id_membre = :id_membre";
    $sth = $connexion->prepare($sql);
    $sth->execute([":id_membre" => $_GET["id"]]);
    $membre = $sth->fetch();
    if ($membre != false) {
        require 'vue/back/modifierMembre.php';
    } else {
        //error   
    }

    die();
}
//supprimer membre
if (isset($_GET["supprimer"]) && isset($_GET["id"]) && $_GET["type"] == "membre") {
    if ($_SESSION["membre"]["statut"] == 1) {
        $sql = "DELETE FROM membre WHERE id_membre = :id_membre";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_membre" => (int)$_GET["id"]]);
        header("Location: index.php?membres");
        die();
    } else {
        echo 'Accès non autorisé, il faut être admin';
    }
    die();
}
//afficher annonces
if (isset($_GET["annonces"])) {
    if (!empty($_SESSION)) {
        if ($_SESSION["membre"]["statut"] == 1) {
            $sql = "SELECT * FROM annonce";
            $membres  = $connexion->query($sql)->fetchAll();
            require 'vue/back/gestionAnnonces.php';
        } else {
            echo 'Accès non autorisé, il faut être admin';
        }
    } else {
        header('Location: index.php?connexion');
    }
    die();
}

//modifier annonce
if (isset($_GET["modifier"]) && isset($_GET["id"])) {
    if ($_GET["type"] == "annonce") {
        var_dump($_GET["type"]);

        $sql = "SELECT * FROM annonce WHERE id_annonce = :id_annonce";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_annonce" => $_GET["id"]]);
        $annonce = $sth->fetch();
        if ($annonce != false) {
            require 'vue/back/modifierAnnonce.php';
        } else {
            //error
        }
    }
    die();
}
//supprimer annonce
if (isset($_GET["supprimer"]) && isset($_GET["id"]) && $_GET["type"] == "annonce") {
    if ($_SESSION["membre"]["statut"] == 1) {
        $sql = "DELETE FROM annonce WHERE id_annonce = :id_annonce";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_annonce" => (int)$_GET["id"]]);
        header("Location: index.php?annonces");
        die();
    } else {
        echo 'Accès non autorisé, il faut être admin';
    }
    die();
}

//afficher categories
if (isset($_GET["categories"])) {
    if (!empty($_SESSION)) {
        if ($_SESSION["membre"]["statut"] == 1) {
            $sql = "SELECT * FROM categorie";
            $membres  = $connexion->query($sql)->fetchAll();
            require 'vue/back/gestionCategories.php';
        } else {
            echo 'Accès non autorisé, il faut être admin';
        }
    } else {
        header('Location: index.php?connexion');
    }
    die();
}


//modifier categorie
if (isset($_GET["modifier"]) && isset($_GET["id"])) {
    if ($_GET["type"] == "categorie") {
        var_dump($_GET["type"]);
        $sql = "SELECT * FROM categorie WHERE id_categorie = :id_categorie";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_categorie" => $_GET["id"]]);
        $categorie = $sth->fetch();
        var_dump($categorie);
        if ($categorie != false) {
            require 'vue/back/modifierCategorie.php';
        } else {
            //error
        }
    }
    die();
}


//supprimer categories
if (isset($_GET["supprimer"]) && isset($_GET["id"]) && $_GET["type"] == "categorie") {
    if ($_SESSION["membre"]["statut"] == 1) {
        $sql = "DELETE FROM categorie WHERE id_categorie = :id_categorie";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_categorie" => (int)$_GET["id"]]);
        header("Location: index.php?categories");
        die();
    } else {
        echo 'Accès non autorisé, il faut être admin';
    }
    die();
}

//afficher notes
if (isset($_GET["notes"])) {
    if (!empty($_SESSION)) {
        if ($_SESSION["membre"]["statut"] == 1) {
            $sql = "SELECT * FROM note";
            $notes  = $connexion->query($sql)->fetchAll();
            require 'vue/back/gestionNotes.php';
        } else {
            echo 'Accès non autorisé, il faut être admin';
        }
    } else {
        header('Location: index.php?connexion');
    }
    die();
}


//modifier note
if (isset($_GET["modifier"]) && isset($_GET["id"])) {
    if ($_GET["type"] == "note") {
        var_dump($_GET["type"]);
        $sql = "SELECT * FROM note WHERE id_note = :id_note";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_note" => $_GET["id"]]);
        $note = $sth->fetch();
        var_dump($note);
        if ($note != false) {
            require 'vue/back/modifierNote.php';
        } else {
            //error
        }
    }
    die();
}


//supprimer notes
if (isset($_GET["supprimer"]) && isset($_GET["id"]) && $_GET["type"] == "note") {
    if ($_SESSION["membre"]["statut"] == 1) {
        $sql = "DELETE FROM note WHERE id_note = :id_note";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_note" => (int)$_GET["id"]]);
        header("Location: index.php?notes");
        die();
    } else {
        echo 'Accès non autorisé, il faut être admin';
    }
    die();
}
//afficher commentaires
if (isset($_GET["commentaires"])) {
    if (!empty($_SESSION)) {
        if ($_SESSION["membre"]["statut"] == 1) {
            $sql = "SELECT * FROM commentaire";
            $commentaires  = $connexion->query($sql)->fetchAll();
            require 'vue/back/gestionCommentaires.php';
        } else {
            echo 'Accès non autorisé, il faut être admin';
        }
    } else {
        header('Location: index.php?connexion');
    }
    die();
}


//modifier commentaire
if (isset($_GET["modifier"]) && isset($_GET["id"])) {
    if ($_GET["type"] == "commentaire") {
        var_dump($_GET["type"]);
        $sql = "SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_commentaire" => $_GET["id"]]);
        $commentaire = $sth->fetch();
        if ($note != false) {
            require 'vue/back/modifierCommentaire.php';
        } else {
            //error
        }
    }
    die();
}


//supprimer commentaires
if (isset($_GET["supprimer"]) && isset($_GET["id"]) && $_GET["type"] == "commentaire") {
    if ($_SESSION["membre"]["statut"] == 1) {
        $sql = "DELETE FROM commentaire WHERE id_commentaire = :id_commentaire";
        $sth = $connexion->prepare($sql);
        $sth->execute([":id_commentaire" => (int)$_GET["id"]]);
        header("Location: index.php?commentaires");
        die();
    } else {
        echo 'Accès non autorisé, il faut être admin';
    }
    die();
}
