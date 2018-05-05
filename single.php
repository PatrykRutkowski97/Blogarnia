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
    <title>Dodaj artykuł</title>
</head>
<body>
    
    <?php require_once('header.php'); ?>

    <div class="container back">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            </div>
        </div>
                <div class="card">  
                        <?php
                        $id = $_GET['id'];
                        include('connect.php');
                        $connection11 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
                        if($result = $connection11->query("SELECT * FROM artykuly WHERE id='$id'"))
                        {
                            $article = mysqli_fetch_array($result);
                            
                            echo '<div class="card">';
                            echo '<img class="card-img-top" src="' . $article['url'] . '" alt="Główny obrazek"';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title single">' . $article['tytul'] . '</h5>';
                            echo '<p class="card-text single">' . $article['tresc'] . '</p>';
                            echo '<div class="alert alert-light" role="alert">'. $article['autor'] .'</div>';
                            echo '</div></div>';
                        }

                        ?>
                </div>
    </div>

    <?php require_once('footer.php'); ?>

</body>
</html>