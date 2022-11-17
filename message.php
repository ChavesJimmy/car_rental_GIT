<?php 
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

//php
$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM messages";
$res=mysqli_query($connect, $sql);
$tbody="";
if (mysqli_num_rows($res)  > 0) {
    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    
    $tbody .=  $row['user_email'] . "<br>" . $row['message']
      ;}
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <?php require_once "./components/boot.php" ?>
</head>
<body>
    <?= $tbody?>
</body>
</html>