<?php
session_start();
if (isset($_SESSION['id']))
{
$bdd = new PDO('mysql:host=localhost:8889;dbname=Blog', 'root', 'root');

$requser = $bdd->query('SELECT id, nom, prenom, mail, pseudo, DATE_FORMAT(dateinscription, \'%d/%m/%Y \') AS dateinscription FROM connexionBlog WHERE id=' . $_SESSION['id']);
$db = $requser->fetch();

if (isset($_POST['ajouter']) && !empty($_POST['titre']) && !empty($_POST['billet'])) {
    $reqbillet = $bdd->prepare('INSERT INTO blog(titre, billet, date, pseudo) VALUES(?, ?, NOW(), ?)');
    $reqbillet->bindParam(1, $_POST['titre']);
    $reqbillet->bindParam(2, $_POST['billet']);
    $reqbillet->bindParam(3, $_SESSION['pseudo']);
    $reqbillet->execute();
}
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>Page de Profil</title>
</head>
<body>

<?php
echo '<p>' . $db['nom'] . ' ' . $db['prenom'] . '</p>';
echo '<p>' . $db['mail'] . '</p>';
echo '<p>' . $db['pseudo'] . '</p>';
echo '<p>' . $db['dateinscription'] . '</p>';

?>

<p class="titrepage">Ajouter un billet :</p>
<div class="billet">
    <form action="" method="POST">
        <p><textarea id="texttitre" type="text" name="titre" placeholder="Titre" cols="30" rows="2"></textarea>
        <p><textarea id="textarticle" rows="8" cols="122" type="text" name="billet"
                     placeholder="Ajouter votre article ici !"></textarea></p>
        <input class="btnajouter" type="submit" name="ajouter" value="Ajouter">
    </form>
</div>
<div>
    <form action="" method="POST">
        <input type="datetime" name="datenaissance">
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