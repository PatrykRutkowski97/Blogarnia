<?php
session_start();

$login = $_SESSION['login'];
$id = $_GET['id'];

include_once('connect.php');

$connection10 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);

$delete = $connection10->query("DELETE FROM artykuly WHERE id='$id'");
$posty = $connection10->query("UPDATE uzytkownicy SET posty = posty-1 WHERE login='$login'");
$_SESSION['posty'] -= 1;

header("Location: all.php");


?>