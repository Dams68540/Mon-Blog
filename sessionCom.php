<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');


if (!empty($_SESSION))
{
if (isset($_GET['billet'])) {
    $recupBillets = $bdd->prepare('SELECT id, titre, billet, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date FROM blog WHERE id=' . $_GET['billet']);
    $recupBillets->bindParam(1, $_POST['id']);
    $recupBillets->bindParam(2, $_POST['titre']);
    $recupBillets->bindParam(3, $_POST['billet']);
    $recupBillets->bindParam(4, $_POST['date']);
    $recupBillets->execute();
    $db = $recupBillets->fetch();
}
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>Commentaire</title>
    <link rel="stylesheet" href="css/blog.css">
</head>
<body>
<a href="User.php?id= . $_SESSION['id']">Accueil</a>
<H1>Mon super blog </H1>


<?php

echo '<p class="billet"><H3>' . $db['titre'] . ' &nbsp;' . date($db['date']) . '</H3></p>';
echo '<p id="billet">' . htmlentities($db['billet']) . '</p>';

?>

<H4>Commentaires :</H4>

<form action="" method="post">
    <label>Commentaire :</label>
    <input type="text" name="commentaire">
    <input type="submit" name="envoyer" value="Envoyer">
</form>

<?php
if (isset($_POST['accueil'])) {
    header('Location : ../User.php?id=' . $_SESSION['id']);
    exit();
}

if (isset($_POST['envoyer']) && !empty($_POST['commentaire'])) {
    $reqcommentaire = $bdd->prepare('INSERT INTO commentaires(id_billet, pseudo, commentaire, date) VALUES (?, ?, ?, NOW())');
    $reqcommentaire->bindParam(1, $_GET['billet']);
    $reqcommentaire->bindParam(2, $_SESSION['pseudo']);
    $reqcommentaire->bindParam(3, $_POST['commentaire']);
    $db = $reqcommentaire->execute();
}

if (isset($_GET["billet"])) {
    $billet = $_GET["billet"];
    $recupcommentaire = $bdd->prepare('SELECT id, id_billet, pseudo, commentaire, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date FROM commentaires WHERE id_billet = ' . $billet . ' ORDER BY id DESC LIMIT 0, 30');
    $recupcommentaire->bindParam(1, $_POST['id']);
    $recupcommentaire->bindParam(2, $_POST['id_billet']);
    $recupcommentaire->bindParam(3, $_SESSION['pseudo']);
    $recupcommentaire->bindParam(4, $_POST['commentaire']);
    $recupcommentaire->bindParam(5, $_POST['date']);
    $recupcommentaire->execute();
    $db = $recupcommentaire->fetchAll();

    foreach ($db as $com) {
        echo '<p><strong>' . htmlentities($com['pseudo']) . ' : ' . date($com['date']) . '</strong></p>';
        echo '<p>' . htmlentities($com['commentaire']) . '</p>';
    }

}

}
else {
    header('Location: connexionBlog.php');
}
?>


</body>
</html>