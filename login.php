<?php
session_start();
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
<?php

require_once('connect.php');

$connection = @new mysqli($db_server,$db_user,$db_passwd,$db_name);

if($connection->connect_errno != 0)
{
    include('start-header.php');
    echo '<div class="container top"><div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Błąd!</h4>
    <p>Ops, coś poszło nie tak :(</p>
    <hr>
    <p class="mb-0">Nie udało się nawiązać połączenia z bazą danych.</p>
  </div>
  <a type="button" href="index.php" class="btn btn-info">Powrót</a></div>';
    include('footer.php');
    $_SESSION['status'] = false;
}
else
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND haslo='$haslo'";

    if($result = @$connection->query($sql))
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
            $_SESSION['logowanie_error'] = '
            <div class="alert alert-danger" role="alert">
            Podałeś nieprawidłowy login lub hasło
            </div>';
            $_SESSION['status'] = false;
            header("Location: index.php");
        }
    }


    $connection->close();
}



?>
