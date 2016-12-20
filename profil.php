<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');

if (isset($_SESSION['id']))
{
$nom = $db['nom'];
$prenom = $db['prenom'];
$email = $db['mail'];
$pseudo = $db['pseudo'];
$date = $db['dateinscription']

$recupinfo = $bdd->prepare('SELECT * FROM connexionBlog WHERE id = ?');
$recupinfo->execute(array($nom, $prenom, $email, $pseudo, $date));
$db = $recupinfo->fetch();

var_dump($nom, $prenom, $email, $pseudo, $date);
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Page de Profil</title>
</head>
<body>

<?php

echo '<p>'.htmlentities($nom).'</p>';
echo '<p>'.htmlentities($prenom).'</p>';
echo '<p>'.htmlentities($email).'</p>';
echo '<p>'.htmlentities($pseudo).'</p>';
echo '<p>'.$date.'</p>';


}
else
{
    header('Location: connexionBlog.php');
}
?>



</body>
</html>