<?php
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once 'components/db_connect.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM booking WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $car = $data['fk_car'];
        $user = $data['fk_userID'];
        $booking = $data['booking_code'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 70%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>

<body>
    <fieldset>
        <legend class='h2 mb-3'>Delete Booking :                <?php echo $booking ?>
    </legend>
        <h5>You have selected the booking below:</h5>
        <table class="table w-75 mt-3">
            <tr>
                <td>Booking Code : <?php echo $booking ?></td>
            </tr>
            <tr>
                <td>User Name : <?php echo $user ?></td>
            </tr>
            <tr>
                <td>Car Model : <?php echo $car ?></td>
            </tr>
        </table>

        <h3 class="mb-4">Do you really want to delete this Booking?</h3>
        <form action="actions/a_delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input type="hidden" name="picture" value="<?php echo $picture ?>" />
            <button class="btn btn-danger" type="submit">Yes, delete it!</button>
            <a href="index.php"><button class="btn btn-warning" type="button">No, go back!</button></a>
        </form>
    </fieldset>
</body>
</html>