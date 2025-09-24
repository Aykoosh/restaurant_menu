<?php
    $_servername = "localhost";
    $user_name = "root";
    $password = "";
    $DBname = "amtat_hool";

    $conn = new mysqli($_servername, $user_name, $password, $DBname);

    if ($conn->connect_error){
        die("Холболтын алдаа гарлаа: ". $conn->connect_error);
    }

    ?>