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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="odstep">Ranking użytkowników</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <table class="table table-striped text-center">
                            <thead>
                              <tr>
                                <th scope="col">Pozycja</th>
                                <th scope="col">Użytkownik</th>
                                <th scope="col">Artykuły</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $login = $_SESSION['login'];
                            include_once('connect.php');
                            $connection6 = @new mysqli($db_server,$db_user,$db_passwd,$db_name);
                            if($result = $connection6->query("SELECT * FROM uzytkownicy ORDER BY posty DESC"))
                            {
                              $number = 1;
                              while($user = mysqli_fetch_array($result))
                              {
                                if($user['login'] == $login)
                                {
                                  echo '<tr class="bg-primary" style="color: white;">';
                                  echo '<th scope="row">' . $number .'</th>';
                                  echo '<td>' . $user['login'] . '</td>';
                                  echo '<td>' . $user['posty'] . '</td>';
                                  echo '</tr>';
                                  $number++;
                                }
                                else
                                {
                                echo '<tr>';
                                echo '<th scope="row">' . $number .'</th>';
                                echo '<td>' . $user['login'] . '</td>';
                                echo '<td>' . $user['posty'] . '</td>';
                                echo '</tr>';
                                $number++;
                              }
                            }
                            }

                            ?>
                            <!--
                              <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>13</td>
                              </tr>
                              <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>5</td>
                              </tr>
                              <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>2</td>
                              </tr>
                              <tr>
                                    <th scope="row">4</th>
                                    <td>Larry</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                        <th scope="row">5</th>
                                        <td>Larry</td>
                                        <td>2</td>
                                      </tr>
                                      <tr>
                                            <th scope="row">6</th>
                                            <td>Larry</td>
                                            <td>2</td>
                                          </tr>
                                          <tr>
                                                <th scope="row">7</th>
                                                <td>Larry</td>
                                                <td>2</td>
                                              </tr>
                                               -->
                            </tbody>
                          </table>
            </div>
        </div>
    </div>

    <?php require_once('footer.php'); ?>

</body>
</html>