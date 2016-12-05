<?php
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');

$articlesParPage = 5;
$articlesTotalesReq = $bdd->query('SELECT id FROM blog');
$articlesTotales = $articlesTotalesReq->rowCount();
$pageTotales = ceil($articlesTotales/$articlesParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pageTotales)
{
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];
}
else
{
    $pageCourante = 1;
}

$depart =  ($pageCourante-1)*$articlesParPage;

if (isset($_POST['envoyer']) && !empty($_POST['titre']) && !empty($_POST['billet']))
{
    $reqbillet = $bdd->prepare('INSERT INTO blog(titre, billet, date) VALUES (?, ?, NOW())');
    $reqbillet->bindParam(1, $_POST['titre']);
    $reqbillet->bindParam(2, $_POST['billet']);
    $reqbillet->execute();
}

$recupBillets = $bdd->query('SELECT id, titre, billet, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date FROM blog ORDER BY id DESC LIMIT '.$depart.', '.$articlesParPage);
$db = $recupBillets->fetchAll();
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Mon super blog</title>
    <link rel="stylesheet" href="css/blog.css">
</head>
<body>


    <h1 class="TITRE">Mon super blog</h1>

    <div class="barrenav">
        <a class="navlien" href="connexionblog.php">Connexion</a>
        <a class="navlien" href="inscription_blog.php">Inscription</a>
    </div>
    <?php
    foreach($db as $byte)
    {
        echo '<div class="billet"><H3 class="titreart">'.$byte['titre'].'</H3>';
        echo '<p id="texte">'.htmlentities($byte['billet']).'</p>';
        echo '<p class="commentaire padding">'.date($byte['date']).'</p>'.'<p class="commentaire align-right align-up"><a class="btn-com" href="Commentaires.php?billet='.$byte['id'].'">Commentaires</a></p></div>';
    }
    ?>
<br>
    <?php
    for ($i=1;$i<=$pageTotales;$i++)
    {
        if($i == $pageCourante)
        {
    echo $i.' ';
        }
        else
        {
            echo '<a class="pagination" href="blog.php?page='.$i.'">'.$i.' &nbsp;'.'</a>';
        }
    }
    ?>

</body>
</html>