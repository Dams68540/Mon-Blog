<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription Blog</title>
    <link rel="stylesheet" href="css/Inscription.css">
</head>
<body>
<h1 class="TITRE">Inscription du blog</h1>
<div class="barrenav">
    <a class="navlien" href="blog.php">Accueil</a>
    <a class="navlien" href="connexionBlog.php">Connexion</a>
</div>

<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');


if (isset($_POST['inscription'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['mail'];
    $email2 = $_POST['mail2'];
    $pseudo = $_POST['pseudo'];
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);


    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['pseudo']) && !empty($_POST['mdp']) && !empty($_POST['mdp2'])) {
        $pseudolength = strlen($pseudo);
        if ($pseudolength <= 36) {
            if ($email == $email2) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $reqmail = $bdd->prepare("SELECT * FROM connexionBlog WHERE mail = ?");
                    $reqmail->execute(array($email));
                    $mailexist = $reqmail->rowCount();
                    if ($mailexist == 0) {
                        $reqpseudo = $bdd->prepare("SELECT * FROM connexionBlog WHERE  pseudo = ?");
                        $reqpseudo->execute(array($pseudo));
                        $pseudoexist = $reqpseudo->fetch();
                        if ($pseudoexist == 0) {
                            if ($mdp == $mdp2) {
                                $insertmdp = $bdd->prepare('INSERT INTO connexionBlog(grade, nom, prenom, mail, pseudo, motdepasse, dateinscription) VALUES (1, ?, ?, ?, ?, ?, NOW())');
                                $insertmdp->execute(array($nom, $prenom, $email, $pseudo, $mdp));
                                $erreur = 'Votre compte à bien été créé !';
                            } else {
                                $erreur = 'Les mots de passe ne correspondent pas !';
                            }
                        }
                        else
                        {
                            $erreur = 'Ce pseudo existe déjà';
                        }
                    } else {
                        $erreur = 'Cette adresse Email existe déjà !';
                    }
                } else {
                    $erreur = 'Votre adresse email n\'est pas valide !';
                }
            } else {
                $erreur = 'Les adresses Email ne correspondent pas !';
            }
        } else {
            $erreur = 'Le pseudo doit être inférieur à 36 caractères !';
        }
    } else {
        $erreur = 'Tous les champs doivent être complétés !';
    }
}



?>

<div class="Titreblock">
    Inscription :
</div>

<form action="" method="POST">
    <div class="inscription">
        <p align="center"><input class="form" type="text" name="nom" placeholder="Votre nom..."></p>
        <p align="center"><input class="form" type="text" name="prenom" placeholder="Votre prénom..."></p>
        <p align="center"><input class="form" type="email" name="mail" placeholder="Votre adresse email..."></p>
        <p align="center"><input class="form" type="email" name="mail2"
                                 placeholder="Confirmation de votre adresse email..."></p>
        <p align="center"><input class="form" type="text" name="pseudo" placeholder="Votre pseudo..."></p>
        <p align="center"><input class="form" type="password" name="mdp" placeholder="Votre mot de passe..."></p>
        <p align="center"><input class="form" type="password" name="mdp2"
                                 placeholder="Confirmation de votre mot de passe..."></p>
        <p align="center"><input class="btninscription" type="submit" name="inscription" value="S'inscrire">
    </div>

</form>

<?php

if (isset($erreur)) {
    ?>
    <script>alert("<?php echo $erreur ?>")</script>
    <?php
}
?>
</body>
</html>