<?php
    function script_alert($m) {
        echo "<script>alert('$m');</script>";
    }

    $login = $_POST['login'];
    $pass = $_POST['password'];

    if ($login != 'admin' || $pass != '123') {
        script_alert("Неверный логин или пароль."); 
        echo "<script>document.location='admin_sign_in.html'</script>";
        exit;
    }

    $id_ticket = intval($_POST['id_ticket_to_delete']);
    if ($id_ticket) {
        $mysql = new mysqli("localhost", "root", "", "theatre");
        $mysql->query("SET NAMES 'utf8';");
        
        $check_query = $mysql->query("SELECT EXISTS(SELECT * from `tickets` WHERE `id_ticket`=$id_ticket);");
        $result = $check_query->fetch_assoc();

        if ($result["EXISTS(SELECT * from `tickets` WHERE `id_ticket`=$id_ticket)"]) {
            $mysql->query("DELETE FROM `tickets` WHERE `id_ticket` = $id_ticket");
            script_alert("Билет №". $id_ticket . " был успешно удален из базы.");
        } 

        $mysql->close();
    }

    $id_sub = intval($_POST['id_sub_to_delete']);
    if ($id_sub) {
        $mysql = new mysqli("localhost", "root", "", "theatre");
        $mysql->query("SET NAMES 'utf8';");

        $check_query = $mysql->query("SELECT EXISTS(SELECT * from `subscription` WHERE `id`=$id_sub);");
        $result = $check_query->fetch_assoc();

        if ($result["EXISTS(SELECT * from `subscription` WHERE `id`=$id_sub)"]) {
            $mysql->query("DELETE FROM `subscription` WHERE `id` = $id_sub");
            script_alert("Абонемент №". $id_sub . " был успешно удален из базы.");
        } 

        $mysql->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css\style.css" />
        <link rel="stylesheet" href="css\style-table.css" />
        <link rel="stylesheet" href="css\style-form.css" />
        <title>Администраторская</title>
    </head>
    <body>
        <header>
            <h1>Театр "LevoClevo"</h1>
            <ul class="navbar-menu">
                <a href="index.html">
                    <li class="button-style" id="clr">На главную/<br>Выход</li>
                </a>
            </ul>
        </header>

        <article>
            <div class="head-menu" style="height: 130px;">
                <h2
                    style="
                        margin-top: 50px;
                        margin-bottom: 50px;
                        text-align: center;">
                    Панель администратора
                </h2>
            </div>

            <p>Добро пожаловать в панель администратора.</p>
            <p>Здесь находится информация о всех забронированных билетах и абониментах.</p>
            
            <div class="table-block" id="table-first">
                <table>
                <tr> 
                    <th colspan=6>База бронировния билетов</th> 
                </tr>
                <tr> 			
                    <td>ID</td>
                    <td>Фамилия</td> 			  
                    <td>Имя</td> 			
                    <td>Отчество</td>
                    <td>E-mail</td>
                    <td>Дата брони</td> 
                </tr>
                <!-- Вывод информации из бд tickets -->
                <?php
                    $mysql = new mysqli("localhost", "root", "", "theatre");
                    $mysql->query("SET NAMES 'utf8';");
                    $tickets = $mysql->query("SELECT * FROM `tickets`;");

                    if ($tickets->num_rows > 0) {
                        while ($row = $tickets->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td>".$row['id_ticket']."</td>";
                                echo "<td>".$row['sername']."</td>";
                                echo "<td>".$row['name']."</td>";
                                echo "<td>".$row['patronimic']."</td>";
                                echo "<td>".$row['email']."</td>";
                                echo "<td>".$row['date_order']."</td>";
                            echo "</tr>";
                        }
                    }

                    $mysql->close();
                ?>
                </table>

                <div class="input-del">
                    <form action="admin_page.php" method="post" id="admin-del-form">
                        <ul class="wrapper">
                            <li class="form-row">
                                <label for="id_ticket_to_delete">Удалить билет по ID:</label>
                                <input type="text" name="id_ticket_to_delete" id="id_ticket_to_delete">
                            </li>

                            <li class="form-row">
                                <label for="login">Логин:</label>
                                <input type="text" name="login" id="login">
                            </li>
                            <li class="form-row">
                                <label for="password">Пароль:</label>
                                <input type="password" name="password" id="password">
                            </li>

                            <li class="form-row">
                                <button type="submit" name="submit" class="button-style" id="submit">Удалить</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>

            <div class="table-block">
                <table>
                <tr> 
                    <th colspan=7>База бронирования абониментов</th> 
                </tr>
                <tr> 			
                    <td>ID</td>
                    <td>Фамилия</td> 			  
                    <td>Имя</td> 			
                    <td>Отчество</td>
                    <td>E-mail</td>
                    <td>Дата брони ОТ</td>
                    <td>Дата брони ДО</td> 
                </tr>
                <!-- Вывод информации из бд subscriptions -->
                <?php
                    $mysql = new mysqli("localhost", "root", "", "theatre");
                    $mysql->query("SET NAMES 'utf8';");
                    $subs = $mysql->query("SELECT * FROM `subscription`;");

                    if ($subs->num_rows > 0) {
                        while ($row = $subs->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['sername']."</td>";
                                echo "<td>".$row['name']."</td>";
                                echo "<td>".$row['patronimic']."</td>";
                                echo "<td>".$row['email']."</td>";
                                echo "<td>".$row['date_from']."</td>";
                                echo "<td>".$row['date_to']."</td>";
                            echo "</tr>";
                        }
                    }

                    $mysql->close();
                ?>
                </table>

                <div class="input-del">
                    <form action="admin_page.php" method="post" id="admin-del-form">
                        <ul class="wrapper">
                            <li class="form-row">
                                <label for="id_sub_to_delete">Удалить абонимент по ID:</label>
                                <input type="text" name="id_sub_to_delete" id="id_sub_to_delete">
                            </li>

                            <li class="form-row">
                                <label for="login">Логин:</label>
                                <input type="text" name="login" id="login">
                            </li>
                            <li class="form-row">
                                <label for="password">Пароль:</label>
                                <input type="password" name="password" id="password">
                            </li>

                            <li class="form-row">
                                <button type="submit" name="submit" class="button-style" id="submit">Удалить</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>

        </article>

        <footer>
			<h4>Дополнительная информация о сайте.</h4>

			<p>© 2022 SUAI. All rights reserved.</p>
			<p>Rusanov Maxim V. | group 4918</p>
		</footer>
    </body>
</html>