<?php
session_start();
if($_SESSION['status'] == false)
{
  header("Location: index.php");
}
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Twoje posty</title>
</head>
<body>
    <?php require_once('header.php'); ?>
    <div class="container top">
        <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="alert alert-warning" role="alert">
        <b>Uważaj</b> jedno kliknięcie usuwa artykuł !
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        </div>
        <div class="row">
    <?php
    include_once('connect.php');
    $login = $_SESSION['login'];
    $connection7 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
    if($result = $connection7->query("SELECT * FROM artykuly WHERE autor='$login' ORDER BY id DESC"))
    {
        $ilosc = $result->num_rows;
        if($ilosc <= 0)
        {
            echo '<h4>Nie masz jeszcze żadnych artykułów...</h4>';
        }
        else
        {
            while($article = mysqli_fetch_array($result))
            {
                echo '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 top"> ';
                echo '<div class="card" style="width: 18rem;">';
                echo '<img class="card-img-top" src="'. $article['url'] .'" alt="Card image cap" height="150" width="350">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'. $article['tytul'] .'</h5>';
                echo '<p class="card-text">' . $article['podtytul'] . '</p>';
                echo '<a href="single.php?id=' . $article['id'] . '" class="btn btn-outline-primary btn-block">Zobacz</a>';
                echo '<a href="delete.php?id='. $article['id'] .'" class="btn btn-outline-danger btn-block">Usuń</a>';
                echo '</div></div></div>';
            }
        }
    }
    ?>
        </div>
    </div>
    <?php require_once('footer.php'); ?>
</body>
</html>