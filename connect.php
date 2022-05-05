<?php

    $ip = "127.0.0.1";
    $user = "root";
    $pass = "";
    $db = "shop";

    $conn = new mysqli($ip,$user,$pass,$db);

    $conn->query("SET NAMES UTF8");

?>