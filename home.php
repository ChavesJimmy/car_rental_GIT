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
$res2 = mysqli_query($connect, "SELECT * FROM users 
JOIN booking ON booking.fk_userID=users.id
JOIN cars ON booking.fk_car=cars.id WHERE first_name=". $_SESSION['user']);
$row2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);
mysqli_close($connect);
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
        <div class="hero">
            <img class="userImage" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
            <p class="text-white">Hi <?php echo $row['first_name']; ?></p>
        </div>
        <a href="logout.php?logout">Sign Out</a>
        <a href="updateUser.php?id=<?php echo $_SESSION['user'] ?>">Update your profile</a>
        <a href="cars/index.php?id=<?php echo $_SESSION['user'] ?>">Book a Car</a>

    </div>
    <fieldset>
        <legend class='h2'>book a car</legend>
        <form action="actions/a_bookCar.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Car</th>
                    <td><select name="model">
                        <?php echo "" ?>
                    </select></td>
                </tr>

                <tr>
                    <th>User</th>
                    <td><?php echo $row['first_name']?></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                    <td>
                        <button class="btn btn-success" type="submit">Book</button></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>