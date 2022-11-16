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
$sql = "SELECT * FROM users WHERE status != '$status'";
$sql2 = "SELECT * FROM booking
JOIN users ON users.id=booking.fk_userID
JOIN cars ON booking.fk_car=cars.id";

$result = mysqli_query($connect, $sql);
$result2 = mysqli_query($connect, $sql2);
//this variable will hold the body for the table
$tbody = '';
$tbody2 = '';
$rowImage = $result2->fetch_array(MYSQLI_ASSOC);
$image=$rowImage['picture'];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src=' ".$row['picture']."' alt=" . $row['first_name'] . "/></td>
            <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
            <td>" . $row['date_of_birth'] . "</td>
            <td>" . $row['email'] . "</td>
            <td><a href='updateUser.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm m-auto' type='button'>Edit</button></a>
            <a href='deleteUser.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm m-auto' type='button'>Delete</button></a></td>
         </tr>";}
         
         while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
         $tbody2 .= "<tr>
            <td>" . $row2['booking_code'] . "</td>
            <td>" . $row2['first_name'] . "</td>
            <td>" . $row2['model'] . "</td>
            <td>" . $row2['price'] . "</td>
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
    <div class="container">
        <div class="row">
            <div class="col-2">
                <img  class="userImage" src="<?php echo $image ?>" alt="Adm avatar">
                <p class="">Administrator</p>
                <a class="w-100 m-1 btn btn-danger" href="logout.php?logout">Sign Out</a>
            </div>
            <div class="col-8 mt-2">
                <p class='h2'>Users</p>

                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Date of birth</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
                <p class='h2'>Booking</p>

                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Booking Code</th>
                            <th>User</th>
                            <th>Car</th>
                            <th>Price</th>
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