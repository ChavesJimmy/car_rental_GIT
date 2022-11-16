<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
//if it is a user it will create a back button to home.php
if (isset($_SESSION["user"])) {
    $backBtn = "home.php";
}
//if it is a adm it will create a back button to dashboard.php
if (isset($_SESSION["adm"])) {
    $backBtn = "dashboard.php";
}
//fetch and populate form
if (isset($_GET['id'])) {
    if ($_GET['id']) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM booking WHERE id = {$id}";
        $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) == 1) {
                $data = mysqli_fetch_assoc($result);
                $carID=$data['fk_car'];
                $bookCode=$data['booking_code'];
                $userID=$data['fk_userID'];
            }}
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id = {$id}";
        $result = mysqli_query($connect, $sql);
        
            if (mysqli_num_rows($result) == 1) {
            $data2 = mysqli_fetch_assoc($result);
            $userID=$data2['id'];
    }
}


//update
$class = 'd-none';
if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $carID = $_POST['fk_car'];
    $userID = $_POST['fk_userID'];
    $sql = "UPDATE booking SET fk_car='$carID', fk_userID='$userID' WHERE id = {$id}";
    if (mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        header("refresh:5;url=updateBooking.php?id={$id}");
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
        header("refresh:5;url=updateBooking.php?id={$id}");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
        <fieldset>
        <legend class='h2'>UPDATE BOOKING</legend>

        <form method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Car ID</th>
                    <td><input type="number" name="fk_car" value="<?php echo $carID ?>">
                </td>
                </tr>
                <tr>
                    <th>Booking Code</th>
                    <td><?= $bookCode ?>
                </td>
                 <tr>
                    <th>User_id</th>
                    <td><input type="number" name="fk_userID" value="<?php echo $userID ?>">
                </td>
              
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                    <td>
                        <button class="btn btn-success" name="submit" type="submit">Update</button></td>
                    <td>
                        <a href="index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
    </div>
</body>
</html>