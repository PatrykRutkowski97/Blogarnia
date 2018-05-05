<?php

include('connect.php');

$connection5 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
$login = trim($_POST['login']);
$haslo = trim($_POST['haslo']);
$haslo2 = trim($_POST['haslo2']);
$email = $_POST['email'];
$posty = 0;


    $dodawanie = $connection5->prepare("INSERT uzytkownicy (login,haslo,email,posty) VALUES (?,?,?,?)");
    $dodawanie->bind_param("sssi",$login,$haslo,$email,$posty);
    $dodawanie->execute();
    $dodawanie->close();

    header("Location: index.php");


?>