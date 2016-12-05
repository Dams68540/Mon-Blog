<?php
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
session_start();
if (isset($_SESSION['id']))
{
    $comptereq = $bdd->prepare('SELECT * FROM connexionBlog WHERE id = ?');
    $comptereq->execute(array($_SESSION['id']));
    $compteok = $comptereq->fetch();
    if ($compteok['grade'] <= 1)
    {
        header('Location : ../');
        exit();
    }
}else{

    echo '<META http-equiv="refresh" content="0; URL=connexionBlog.php">';
    exit();
}

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
    <title>Admin</title>
    <link rel="stylesheet" href="css/Admin.css">
</head>
<body>
    <?php
    echo '<h1 class="TITRE">BONJOUR'.' '. $_SESSION['pseudo'].'</h1>'
    ?>
    <div class="barrenav">
        <a class="navlien" href="ajout.php">Ajouter un billet</a>
        <a class="navlien" href="viewuser.php">Vue des utilisateurs</a>
        <a class="navlien" href="deconnexionBlog.php">Se déconnecter</a>
    </div>
</div>

<div class="drnarticle">Dernier article publié</div>
<?php
foreach($db as $bite)
{
    echo '<div class="billet"><H3 class="titreart">'.$bite['titre'].'</H3>';
    echo '<p class="billet">'.htmlentities($bite['billet']);
    echo '<p class="edit">'.date($bite['date']).'</p>'.'<p class="edit"><a href="edit.php?billet='.$bite['id'].'">Edit</a></p></div>';
}
?>
<br>
<div class="pagination">
<?php
for ($i=1;$i<=$pageTotales;$i++)
{

    if($i == $pageCourante)
    {
        echo $i.' ';
    }
    else
    {
        echo '<a class=liens href="Admin.php?page='.$i.'">'.$i.' &nbsp;'.'</a>';
    }
}
    ?>
</div>
</body>
</html>