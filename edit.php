<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');

if (isset($_SESSION))
{

if (isset($_GET['billet']))
{
$recupBillets = $bdd->prepare('SELECT id, titre, billet, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date FROM blog WHERE id=' . $_GET['billet']);
$recupBillets->bindParam(1, $_POST['id']);
$recupBillets->bindParam(2, $_POST['titre']);
$recupBillets->bindParam(3, $_POST['billet']);
$recupBillets->bindParam(4, $_POST['date']);
$recupBillets->execute();
$db = $recupBillets->fetch();

?>


<?php
if (!empty($_SESSION)) {
if (isset($_POST['edit'])) {
    if (!empty($_POST['titre']) && !empty($_POST['billet'])) {
        $modif = $bdd->prepare('UPDATE blog SET titre =?, billet =? WHERE id=?');
        $modif->execute(array($_POST['titre'], $_POST['billet'], $_GET['billet']));

        echo '<META http-equiv="refresh" content="0; URL=Admin.php?id=1">';
        exit();
    }

}

if (isset($_POST['supprimer'])) {
    if (!empty($_POST['titre']) && !empty($_POST['billet'])) {
        $suppr = $bdd->prepare('DELETE FROM blog WHERE id=' . $_GET['billet']);
        $suppr->execute(array($_POST['titre'], $_POST['billet'], $_GET['billet']));

        echo '<META http-equiv="refresh" content="0; URL=Admin.php?id=1">';
        exit();
    }
}

$suppr = $bdd->prepare('SELECT id, titre, billet, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date FROM blog WHERE id=' . $_GET['billet']);
$suppr->bindParam(1, $_POST['id']);
$suppr->bindParam(2, $_POST['titre']);
$suppr->bindParam(3, $_POST['billet']);
$suppr->bindParam(4, $_POST['date']);
$suppr->execute();
$as = $suppr->fetch();

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Commentaire</title>
    <link rel="stylesheet" href="css/Edit.css">
</head>
<body>
<H1 class="TITRE">Mon super blog </H1>

<div class="barrenav">
    <a class="navlien" href="Admin.php">Accueil</a>
</div>

<p class="titrepage">Éditer un article :</p>

<div class="billet">
<form action="" method="post">
    <?php

    echo '<p><textarea id="texttitre" name="titre" cols="30" rows="2">'.$as["titre"].'</textarea></p>';
    echo '<p><textarea id="textarticle" class="textarea" rows="7" cols="123"  type="text" name="billet">' . $as["billet"] . '</textarea></p>';

    }
    ?>
    <p><input class="btnedit" type="submit" name="edit" value="Edit">
        <input class="btnedit" type="submit" name="supprimer" value="Supprimer"></p>
</form>
</div>

<div class="commentaire">
<H4>Commentaires :</H4>


<form action="" method="post">
    <input type="text" name="commentaire">
    <input type="submit" name="envoyer" value="Envoyer">
</form>
</div>

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
            echo '<p><strong>' . htmlentities($com['pseudo']) . ' : ' . date($com['date']) . '</strong></p>';
            echo '<p>' . htmlentities($com['commentaire']) . '</p>';
        }
    }
}
else {
    header('Location: connexionBlog.php');

}
}
?>


</body>
</html>