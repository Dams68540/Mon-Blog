<?php
session_start();

$bdd = new PDO('mysql:host=localhost:8889;dbname=Blog', 'root', 'root');


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
    <link rel="stylesheet" href="css/com.css">
</head>
<body>
<H1 class="TITRE">Mon super blog </H1>

<div class="barrenav">
    <a class="navlien" href="User.php?id= . $_SESSION['id']">Accueil</a>
</div>

<div class="billet">
    <?php

    echo '<p><H3 id="texttitre">' . $db['titre'] . ' &nbsp;' . date($db['date']) . '</H3></p>';
    echo '<p id="textarticle">' . htmlentities($db['billet']) . '</p>';

    ?>
</div>

<H4 class="titrecom"><a id="liencom" href="#haha">Commentaires :</a></H4>


<?php
if (isset($_POST['envoyer']) && !empty($_POST['commentaire'])) {
    $reqcommentaire = $bdd->prepare('INSERT INTO commentaires(id_billet, pseudo, commentaire, date) VALUES (?, ?, ?, NOW())');
    $reqcommentaire->bindParam(1, $_GET['billet']);
    $reqcommentaire->bindParam(2, $_SESSION['pseudo']);
    $reqcommentaire->bindParam(3, $_POST['commentaire']);
    $db = $reqcommentaire->execute();
}

if (isset($_GET['billet'])) {
    $billet = $_GET["billet"];
    $recupcommentaire = $bdd->prepare('SELECT id, id_billet, pseudo, commentaire, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date FROM commentaires WHERE id_billet = ' . $billet . ' ORDER BY id DESC LIMIT 0, 30');
    $recupcommentaire->bindParam(1, $_POST['id']);
    $recupcommentaire->bindParam(2, $_POST['id_billet']);
    $recupcommentaire->bindParam(3, $_POST['pseudo']);
    $recupcommentaire->bindParam(4, $_POST['commentaire']);
    $recupcommentaire->bindParam(5, $_POST['date']);
    $recupcommentaire->execute();
    $db = $recupcommentaire->fetchAll();


    foreach ($db as $com) {
        echo '<div class="commentaire"><p><strong>' . htmlentities($com['pseudo']) . ' : ' . date($com['date']) . '</strong></p>';
        echo '<p>' . htmlentities($com['commentaire']) . '</p></div>';
    }
}
?>
<div class="commentaire">
    <form action="" method="post">
        <p id="haha"></p>
        <textarea id="textcom" name="commentaire" cols="100" rows="4"></textarea>
        <input class="btncom" type="submit" name="envoyer" value="Envoyer">
    </form>
</div>
<?php

}
else {
    header('Location: connexionBlog.php');

}
?>


</body>
</html>