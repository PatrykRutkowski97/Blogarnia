<?php
session_start();
if($_SESSION['status'] == false)
{
  header("Location: index.php");
}
$success = false;
$error = false;
//Dodawanie postu
if(isset($_POST['add']))
{
    $title = strip_tags($_POST['title']);
    $subtitle = strip_tags($_POST['subtitle']);
    $url = strip_tags($_POST['url']);
    $content = strip_tags($_POST['content']);
    $autor = $_SESSION['login'];

    if($url == "")
    {
        $url = "http://via.placeholder.com/350x150";
    }

    if($title == "" || $subtitle == "" ||  $content == "")
        $error = true;
    else
    {
        include_once('connect.php');
        $connection12 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
            $statement = $connection12->prepare("INSERT artykuly (tytul,podtytul,url,tresc,autor) VALUES (?,?,?,?,?)");
            $statement->bind_param("sssss",$title,$subtitle,$url,$content,$autor);
            $statement->execute();
            $statement->close();
            $_SESSION['dodano'] = false;
            $update = $connection12->query("UPDATE uzytkownicy SET posty = posty+1 WHERE login='$autor'");
            $_SESSION['posty'] += 1;
            $success = true;
            $title = "";
            $subtitle = "";
            $url = "";
            $content = "";
    }
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="odstep">Dodaj artykuł</h2>
            </div>
        </div>
        

            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            </div>
                <form method="post" action="add.php">
                <?php if ($success == true) { ?>
                        <div class="alert alert-success" role="alert">
                        <?php 
                        echo '<b>Gratulacje</b> Twój post został właśnie dodany';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>'; 
                        ?>
                        </div>
                        <?php } ?>
                        <?php if ($error == true) { ?>
                        <div class="alert alert-danger" role="alert">
                        <?php 
                        echo '<b>Błąd</b> Uzupełnij wszystkie pola';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>'; 
                        ?>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="title">Tytuł</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php if(isset($title)) echo $title; ?>">
                        </div>
                        <div class="form-group">
                                <label for="subtitle">Krótki opis artykułu (nagłówek)</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" max="10" value="<?php if(isset($subtitle)) echo $subtitle; ?>">
                            </div>
                        <div class="form-group">
                            <label for="url">Adres URL obrazka</label>
                            <input type="text" class="form-control" id="url" name="url" data-toggle="tooltip" data-placement="left" title="Możesz zostawić puste pole" value="<?php if(isset($url)) echo $url; ?>">
                        </div>
                        <div class="from-group">
                            <label for="content">Treść artykułu</label>
                            <textarea class="form-control" rows="5" id="content" name="content" value="<?php if(isset($content)) echo $content; ?>"></textarea>
                        </div>
                        <input type="submit" class="btn btn-outline-primary top" name="add" id="add" value="Dodaj artykuł">
                </form>
            </div>

    </div>
    <?php require_once('footer.php'); ?>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
</body>
</html>