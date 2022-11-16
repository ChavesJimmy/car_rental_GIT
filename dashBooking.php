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

$id = $_SESSION['adm'];
$status = 'adm';
$sql2 = "SELECT * FROM booking";

$result2 = mysqli_query($connect, $sql2);
//this variable will hold the body for the table

$tbody2 = '';
if ($result2->num_rows > 0) {
         while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
         $tbody2 .= "<tr>
            <td>" . $row2['booking_code'] . "</td>
            <td class='m-auto'>
            <a href='updateBooking.php?id=" . $row2['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='deletebooking.php?id=". $row2['id'] ."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
         </tr>";}}
    else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}


mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-Dashboard</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }

        .userImage {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>

<a href="dashUser.php">Manage Users</a>
<a href="dash.Booking.php">Manage Bookings</a>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <p class="">Administrator</p>
                <a class="w-100 m-1 btn btn-danger" href="dashboard.php">Back</a>
            </div>
            
                <p class='h2'>Booking</p>

                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Booking Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody2 ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>