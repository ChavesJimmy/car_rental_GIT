<?php

$localhost = "173.212.235.205";
$username = "jimmycodefactory_car_rent";
$password = "CarRent1!";
$dbname = "jimmycodefactory_car_rent";

// create connection
$connect = new  mysqli($localhost, $username, $password, $dbname);

// check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
// } else {
//     echo "Successfully Connected";
}