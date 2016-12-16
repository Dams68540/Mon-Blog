<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');

if (!empty($_SESSION)) {
    if (isset($_POST['ajouter']) && !empty($_POST['titre']) && !empty($_POST['billet'])) {
        $reqbillet = $bdd->prepare('INSERT INTO blog(titre, billet, date, pseudo) VALUES(?, ?, NOW(), ?)');
        $reqbillet->bindParam(1, $_POST['titre']);
        $reqbillet->bindParam(2, $_POST['billet']);
        $reqbillet->bindParam(3, $_SESSION['pseudo']);
        $reqbillet->execute();
    }
}
else
{
    header('Location: blog.php');
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un billet</title>
    <link rel="stylesheet" href="css/Ajout.css">
</head>
<body>
<h1 class="TITRE">AJOUTER UN BILLET</h1>
<div class="barrenav">
    <a class="navlien" href="User.php">Accueil</a>
</div>
<p class="titrepage">Ajouter un billet :</p>
<div class="billet">
    <form action="" method="POST">
        <p><textarea id="texttitre" type="text" name="titre" placeholder="Titre" id="" cols="30" rows="2"></textarea>
        <p><textarea id="textarticle" rows="8" cols="122" type="text" name="billet" placeholder="Ajouter votre article ici !"></textarea></p>
        <input class="btnajouter" type="submit" name="ajouter" value="Ajouter">
    </form>
</div>

</body>
</html>