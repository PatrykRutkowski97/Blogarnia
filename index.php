<?php
session_start();
if(isset($_SESSION['status']))
{
    if($_SESSION['status'] == true)
    {
        header("Location: kokpit.php");
    }
}
$error_logowanie = false;
$error_login = false;
$error_passwd = false;
$error_email2 = false;
$success = false;

if(isset($_POST['zaloguj']))
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $login2 = htmlentities($login, ENT_QUOTES, "UTF-8");
    $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
    #$haslo = md5($haslo);

    include('connect.php');
    $connection8 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND haslo='$haslo'";
    
    if($result = $connection8->query($sql))
    {
        $users = $result->num_rows;
        if($users > 0)
        {
            $row = $result->fetch_assoc();
            $_SESSION['login'] = $row['login'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['posty'] = $row['posty'];
            $_SESSION['status'] = true;
            header("Location: kokpit.php");
        }
        else
        {
            $error_logowanie = true;
        }

    }
}


if(isset($_POST['add']))
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];
    $email = $_POST['email'];
    $posty = 0;

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
    $haslo2 = htmlentities($haslo2, ENT_QUOTES, "UTF-8");

    include('connect.php');
    $connection9 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);

    $user = "SELECT * FROM uzytkownicy WHERE login='$login'";
    $email_check = "SELECT * FROM uzytkownicy WHERE email='$email'";

    if($result = $connection9->query($user))
    {
        $ile = $result->num_rows;
        if($ile > 0)
        {
            $error_login = true;
            $success = false;
        }
        if($haslo != $haslo2)
        {
            $error_passwd = true;
            $success = false;
        }
        if($result2 = $connection9->query("SELECT * FROM uzytkownicy WHERE email='$email'"))
        {
            $email_free = $result2->num_rows;
            if($email_free > 0)
            {
                $error_email2 = true;
            }
        }
    }
    if(($error_login == false && $error_passwd == false && $error_email2 == false))
        {
            $haslo_code = md5($haslo);
            $dodawanie = $connection9->prepare("INSERT uzytkownicy (login,haslo,email,posty) VALUES (?,?,?,?)");
            $dodawanie->bind_param("sssi",$login,$haslo_code,$email,$posty);
            $dodawanie->execute();
            $dodawanie->close();
            $success = true;

            $login = "";
            $email = "";
        }
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

    <?php require_once('start-header.php'); ?>

    <div class="container">
        <div class="row top">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="jumbotron">
                    <h1 class="display-4">Witaj na stronie</h1>
                    <p class="lead">W naszym serwisie możesz dodawać artykuły jeśli jesteś zarejestrowany. Możesz przeglądać posty innych użytkowników a inni mogą przeglądać twoje.</p>
                    <hr class="my-4">
                    <h4>Zarejestruj się !</h4>
                    <form action="index.php" method="post">
                                                    <?php if ($success == true) { ?>
                                                    <div class="alert alert-success" role="alert">
                                                    <?php 
                                                            echo '<b>Gratulacje</b> Twoje konto właśnie zostało utworzone';
                                                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>'; 
                                                    ?>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if ($error_login == true) { ?>
                                                    <div class="alert alert-danger" role="alert">
                                                    <?php 
                                                                echo 'Podany login jest już zajęty';
                                                                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>'; 
                                                    ?>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if ($error_passwd == true) { ?>
                                                    <div class="alert alert-danger" role="alert">
                                                    <?php 
                                                            echo 'Hasła nie mogą być różne';
                                                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>'; 
                                                    ?>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if ($error_email2 == true) { ?>
                                                    <div class="alert alert-danger" role="alert">
                                                    <?php 
                                                                echo 'Podany email jest już zajęty';
                                                                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>'; 
                                                    ?>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="form-group">
                                                        <label for="login">Login</label>
                                                        <input type="text" class="form-control" id="login" name="login" required="true" value="<?php if(isset($login)) echo $login; ?>">
                                                        <?php echo @$login_error; ?>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="haslo">Hasło</label>
                                                        <input type="password" class="form-control" id="haslo"name="haslo" required="true">
                                                    </div>
                                                    <div class="form-group">
                                                            <label for="haslo2">Powtórz hasło</label>
                                                            <input type="password" class="form-control" id="haslo2" name="haslo2" required="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email </label>
                                                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required="true" value="<?php if(isset($email)) echo $email; ?>">
                                                        <small id="emailHelp" class="form-text text-muted">Twój email będzie zawsze bezpieczny</small>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="regulamin" required="true">
                                                        <label class="form-check-label" for="exampleCheck1">Zapoznałem się z <a href="regulamin.php">regulaminem</a></label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary top" name="add">Stwórz konto</button>
                                                </form>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="row">
                    <h5>Zaloguj się</h5>
                </div>
                <form action="index.php" method="post">
                <?php if ($error_logowanie == true) { ?>
                    <div class="alert alert-danger" role="alert">
                            <?php 
                                echo 'Podałeś nieprawidłowy login lub hasło';
                                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>'; 
                            ?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" name="login" required="true">
                    </div>
                    <div class="form-group">
                        <label for="haslo">Hasło</label>
                        <input type="password" class="form-control" id="haslo"name="haslo" required="true"> 
                    </div>
                    <button type="submit" class="btn btn-primary" name="zaloguj">Zaloguj</button>
                </form>
            </div>
        </div>
    </div>
              <?php require_once('footer.php'); ?>


</body>
</html>