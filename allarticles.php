<?php
session_start();
if($_SESSION['status'] == false)
{
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Artykuły</title>
</head>
<body>
    <?php require_once('header.php'); ?>

    <!-- Początek -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 top">
                <h2>Wszystkie artykuły</h2>
            </div>
        </div>
        <div class="row top">

        <?php
        include('connect.php');
        $login = $_SESSION['login'];
        $connection4 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
        if($result = $connection4->query("SELECT * FROM artykuly ORDER BY id DESC"))
        {
            while($artykuly = mysqli_fetch_array($result))
            {
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 art">';
                    if($artykuly['autor'] == $login)
                        echo '<div class="card text-center border border-primary" style="width: 18rem;">';
                    else
                        echo '<div class="card text-center" style="width: 18rem;">';
                    echo '<img class="card-img-top" src="' . $artykuly['url'] . '" alt="Card image cap" height="150" width="350">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $artykuly['tytul'] . '</h5>';
                    echo '<p class="card-text">'  . $artykuly['podtytul'] . '</p>';
                    if($artykuly['autor'] == $_SESSION['login'])
                    echo '<h6 class="card-title" style="color: #007BFF">' .$artykuly['autor'] . '</h5>';
                    else
                    echo '<h6 class="card-title">' .$artykuly['autor'] . '</h5>';
                    echo '<a href="single.php?id=' . $artykuly['id'] . '" class="btn btn-outline-primary btn-block">Zobacz</a>';
                    echo '</div></div></div>'; 

            }
        }
        ?>  
        </div>
      </div>

    <?php require_once('footer.php'); ?>
</body>
</html>