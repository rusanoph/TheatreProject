<?php
    $mysql = new mysqli("localhost", "root", "", "theatre");
    $mysql->query("SET NAMES 'utf8';");

    $sername = $_POST['sername'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $email = $_POST['email'];
    $date = $_POST['date'];

    // echo $sername . " " . $name . " " . $patronymic . " " . $email . " " . $date;

    $mysql->query("INSERT INTO `tickets`(`sername`, `name`, `patronimic`, `email`, `date_order`)  
    VALUES('$sername', '$name', '$patronymic', '$email', '$date')");

    $mysql->close();

    header("Location: ..\order_ticket.html");
    exit;
?>
