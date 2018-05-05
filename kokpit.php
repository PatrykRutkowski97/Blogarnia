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
    <title>Strona Główna</title>
</head>
<body>
    <?php require_once('header.php'); ?>

    <div class="container back">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="odstep">Witaj <?php echo $_SESSION['login']; ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card text-center">
                        <div class="card-header bg-primary white">
                            Nick
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text"><b><?php echo $_SESSION['login']; ?></b></p>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card text-center">
                        <div class="card-header bg-primary white">
                            Email
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text"><b><?php echo $_SESSION['email']; ?></b></p>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card text-center">
                        <div class="card-header bg-primary white">
                            Posty
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text"><b><?php echo $_SESSION['posty']; ?></b></p>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h3 class="odstep">Ostatnie artykuły</h3>
                </div>
                
        </div>
        <div class="row">
        <?php
        $login = $_SESSION['login'];
        include_once('connect.php');
        $connection2 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
        if($result = $connection2->query("SELECT * FROM artykuly WHERE autor='$login' ORDER BY id DESC LIMIT 3"))
        {
            $ilosc = $result->num_rows;
            if($ilosc <= 0)
            {
                echo '<h1 style="margin-left:2%;">...</h1>';
            }
            else
            {
                while($articles = mysqli_fetch_array($result))
                {
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"> ';
                    echo '<div class="card" style="width: 18rem; height: 25rem;">';
                    echo '<img class="card-img-top" src="'. $articles['url'] .'" alt="Card image cap" height="150" width="350">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">'. $articles['tytul'] .'</h5>';
                    echo '<p class="card-text">' . $articles['podtytul'] . '</p>';
                    echo '<a href="single.php?id=' . $articles['id'] . '" class="btn btn-outline-primary btn-block">Zobacz</a>';
                    echo '</div></div></div>';
                }
            }
        }
        else
        {

        }
        ?>
        </div>
    </div>

    <?php require_once('footer.php'); ?>