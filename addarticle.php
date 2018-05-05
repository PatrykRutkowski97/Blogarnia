<?php
    session_start();
    if($_SESSION['status'] == false)
    {
    header("Location: index.php");
    }
    include('connect.php');
    $connection3 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);

            if(!isset($_POST['title']) || $_POST['title'] == "" || !isset($_POST['subtitle']) || $_POST['subtitle'] == "" || !isset($_POST['content']) || $_POST['content'] == "" || $_POST['url'] == "" || !isset($_POST['url']))
            {
                $_SESSION['error_title'] = 'Wypełnij prawidłowo wszystkie pola';
            }

            $tytul = strip_tags($_POST['title']);
            $podtytul = strip_tags($_POST['subtitle']);
            $tresc = strip_tags($_POST['content']);
            $url = $_POST['url'];
            $autor = $_SESSION['login'];
            if($url == "")
            {
                $url = 'http://via.placeholder.com/350x150';
            }
            $login = $_SESSION['login'];
            $ilosc_postow = $connection3->query("SELECT posty FROM uzytkownicy WHERE login='$login'");
            $statement = $connection3->prepare("INSERT artykuly (tytul,podtytul,url,tresc,autor) VALUES (?,?,?,?,?)");
            $statement->bind_param("sssss",$tytul,$podtytul,$url,$tresc,$autor);
            $statement->execute();
            $statement->close();
            $_SESSION['dodano'] = false;
            $update = $connection3->query("UPDATE uzytkownicy SET posty = posty+1 WHERE login='$login'");
            $_SESSION['posty'] += 1;
            header("Location: add.php");
    ?>