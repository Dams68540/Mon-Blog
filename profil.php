<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');

if (isset($_SESSION['id']))
{

$recupinfo = $bdd->query('SELECT * FROM connexionBlog WHERE id');
$db = $recupinfo->fetch();

$nom = $db['nom'];
$prenom = $db['prenom'];
$email = $db['mail'];
$pseudo = $db['pseudo'];

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Page de Profil</title>
</head>
<body>

<?php

echo '<p>'.$nom.'</p>';
echo '<p>'.$prenom.'</p>';
echo '<p>'.$email.'</p>';
echo '<p>'.$pseudo.'</p>';

}
else
{
    header('Location: connexionBlog.php');
}
?>



</body>
</html>