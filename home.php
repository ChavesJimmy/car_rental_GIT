<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// select logged-in users details - procedural style
$tbody="";
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $row['first_name']; ?></title>
    <?php require_once 'components/boot.php' ?>
    <style>
        .userImage {
            width: 200px;
            height: 200px;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="hero rom">
            <img class="userImage col-4" src="<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
            <p class="text-white col-8">Hi <?php echo $row['first_name']; ?></p>
        </div>

        <div class="d-block m-auto p-3">
        <a class="btn btn-danger" href="logout.php?logout">Sign Out</a>
        <a class="btn btn-warning" href="updateUser.php?id=<?php echo $_SESSION['user'] ?>">Update your profile</a>
        </div>

       <div id="booking">
       <a style="margin-top:15px" class="btn btn-success w-100" href="bookCar.php?id=<?php echo $_SESSION['user'] ?>">Book a car</a>
       </div>


    </div>
</body>
</html>