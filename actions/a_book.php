<?php
session_start();

require_once '../components/db_connect.php';
$id=$_POST['fk_car'];
if ($_POST) {
    $userID = $_POST['fk_userID'];
    $carID = $_POST['fk_car'];
    $booking = $_POST['booking_code'];
    $sql = "INSERT INTO booking (fk_userID, fk_car, booking_code) VALUES ('$userID', '$carID', '$booking')"; $sqlBook="UPDATE cars SET available='booked' WHERE id = {$id}"; 

    if (mysqli_query($connect, $sql) === TRUE) {
        if(mysqli_query($connect,$sqlBook) === TRUE){
    
        $class = "success";
        $message = "The car was successfully booked";
        }
    } else {
        $class = "danger";
        $message = "Error while booking your car : <br>" . mysqli_connect_error();
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking</title>
    <?php require_once '../components/boot.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Booking request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../bookCar.php?id=<?= $id; ?>'><button class="btn btn-warning" type='button'>Back</button></a>
            <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>