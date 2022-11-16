<?php
session_start();

require_once 'components/db_connect.php';
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
$user=$row['first_name'];
$userID=$row['id'];
var_dump($userID);

$resBooking = mysqli_query($connect, "SELECT * FROM booking WHERE id=" . $_SESSION['user']);
$rowBooking = mysqli_fetch_array($resBooking, MYSQLI_ASSOC);

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM cars WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $car = $data['model'];
        $carID = $data['id'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Car</title>
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
    <fieldset>
        <legend class='h2'>BOOKING REQUEST</legend>

        <form action="actions/a_book.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Car</th>
                    <td><?php echo $car ?>
                </td>
                </tr>
                <tr>
                    <th>Car ID</th>
                    <td><input type="number" name="fk_car" value="<?php echo $carID ?>">
                </td>
                </tr>
                <tr>
                    <th>Booking Code</th>
                    <td><input type="number" name="booking_code">
                </td>
                 <tr>
                    <th>User_id</th>
                    <td><input type="number" name="fk_userID" value="<?php echo $userID ?>">
                </td>
                <tr>
                    <th>User</th>
                    <td><?php echo $user?></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                    <td>
                        <button class="btn btn-success" type="submit">Book</button></td>
                    <td>
                        <a href="index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>