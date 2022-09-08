<?php
    $mysql = new mysqli("localhost", "root", "", "theatre");
    $mysql->query("SET NAMES 'utf8';");

    $sername = $_POST['sername'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $email = $_POST['email'];
    $date_from = $_POST['date-from'];
    $date_to = $_POST['date-to'];

    $mysql->query("INSERT INTO `subscription`(`sername`, `name`, `patronimic`, `email`, `date_from`, `date_to`)  VALUES('$sername', '$name', '$patronimic', '$email', '$date_from', '$date_to')");

    $mysql->close();
    header("Location: ..\order_subscription.html");
    exit;
?>