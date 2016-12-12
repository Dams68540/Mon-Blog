<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');

if (isset($_POST['oublie']))
{
    header('Location: mdpoublie.php');
}

if (isset($_POST['connexion'])) {
    $pseudo = $_POST['pseudo'];
    $mdp = sha1($_POST['mdp']);
    if (!empty($pseudo) AND !empty($mdp)) {
        $userreq = $bdd->prepare('SELECT * FROM connexionBlog WHERE pseudo = ? AND motdepasse = ?');
        $userreq->execute(array($pseudo, $mdp));
        $userexist = $userreq->rowCount();
        if ($userexist == 1) {
            $userinfo = $userreq->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mdp'] = $userinfo['motdepasse'];
            $_SESSION['grade'] = $userinfo['grade'];
            if ($userinfo['grade'] == 2) {
                header('Location: Admin.php?id=' . $_SESSION['id']);
            } else {
                header('Location: User.php?id=' . $_SESSION['id']);
            }
        }
    } else {
        $erreur = 'Tous les champs doivent être complétés';
    }
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/Connexion.css">
</head>
<body>

<H1 class="TITRE">PAGE DE CONNEXION</H1>

<div class="barrenav">
    <a class="navlien" href="blog.php">Accueil</a>
    <a class="navlien" href="Inscription_blog.php">Inscription</a>
</div>

<div class="Titreblock">
    Connexion :
</div>

<form action="" method="POST">
<div class="connexion">
                <p align="center"><input class="form" type="text" name="pseudo" placeholder="Votre pseudo..."></p>
                <p align="center"><input class="form" type="password" name="mdp" placeholder="Votre mot de passe..."></p>
                <p><input class="btnconnexion" type="submit" name="connexion" value="Se connecter"></p>
    <?php
    if (isset($_POST['connexion'])) {
        $pseudo = $_POST['pseudo'];
        $mdp = sha1($_POST['mdp']);
        if (!empty($pseudo) AND !empty($mdp)) {
            $userreq = $bdd->prepare('SELECT * FROM connexionBlog WHERE pseudo = ? AND motdepasse = ?');
            $userreq->execute(array($pseudo, $mdp));
            $userexist = $userreq->rowCount();
            if ($userexist == 0) {
                $erreur = 'Mauvais pseudo ou mot de passe';
                echo '<input class="btnconnexion" type="submit" name="oublie" value="Compte oublié">';
            }
        }
    }
    ?>
</div>

</form>

<?php

if (isset($erreur)) {
    echo '<p class="erreur">'.$erreur.'</p>';
}
?>

</body>
</html>