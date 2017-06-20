<?php
$bdd = new PDO('mysql:host=localhost:8889;dbname=Blog', 'root', 'root');

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


$recupBillets = $bdd->query('SELECT id, titre, billet, DATE_FORMAT(date, \'%d/%m/%Y %H:%i:%s\') AS date, pseudo FROM blog ORDER BY id DESC LIMIT '.$depart.', '.$articlesParPage);
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
        $recupgrade = $bdd->prepare('SELECT * FROM connexionBlog WHERE pseudo =?');
        $recupgrade->execute(array($byte['pseudo']));
        $grade = $recupgrade->fetch(pdo::FETCH_OBJ)->grade;

        $_SESSION['grade'] = $grade;

        $grade == 2 ? $gradeUser = ' (Admin)': $gradeUser = '';

        echo '<div class="billet"><H3 class="titreart">'.$byte['titre'].'</H3>';
        echo '<p id="texte">'.htmlentities($byte['billet']).'</p>';
        echo '<p class="commentaire padding">'.date($byte['date']).' - '.$byte['pseudo']. $gradeUser . '</p>'
            .'<p class="commentaire align-right align-up"><a class="btn-com" href="commentaires.php?billet='.$byte['id'].'">Commentaires</a></p></div>';


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
            echo '<a class="pagination" href="index.php?page='.$i.'">'.$i.' &nbsp;'.'</a>';
        }
    }
    ?>

</body>
</html>