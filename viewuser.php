<?php
session_start();
if (!empty($_SESSION))
{
$bdd = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', 'toor');

$requser = $bdd->query('SELECT * FROM connexionBlog');
$db = $requser->fetchAll();
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Vue utilisateur</title>
    <link rel="stylesheet" href="css/userview.css">
</head>
<body>

<h1 class="TITRE">Vue des utilisateurs</h1>

<div class="barrenav">
    <a class="navlien" href="Admin.php?id=1">Accueil</a>
</div>
<div>
<table class="table">
    <thead class="head">
    <th class="th">ID</th>
    <th class="th">Nom</th>
    <th class="th">Prénom</th>
    <th class="th">Email</th>
    <th class="th">Pseudo</th>
    <th class="th">Status</th>
    </thead>
    <tbody>
    <?php
    foreach ($db as $user) {
        ?>
        <tr>
            <td class="td"><?php echo $user['id'] ?></td>
            <td class="td"><?php echo $user['nom'] ?></td>
            <td class="td"><?php echo $user['prenom'] ?></td>
            <td class="td"><?php echo $user['mail'] ?></td>
            <td class="td"><?php echo $user['pseudo'] ?></td>
            <td class="td"><?php echo $user['grade'] ?></td>
        </tr>
        <?php

    }
    }
    else
    {
        header('Location: connexionBlog.php');
    }
?>
    </tbody>
</table>
    </div>
</body>
</html>