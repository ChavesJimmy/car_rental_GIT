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
$id=$row['id'];
//php my reservation
$sqlMyBooking = "SELECT * FROM booking 
JOIN cars ON cars.id=booking.fk_car
JOIN users ON users.id=booking.fk_userID WHERE fk_userID=$id";
$resultMyBooking = mysqli_query($connect, $sqlMyBooking);
$tbody2 = ''; //this variable will hold the body for the table
if (mysqli_num_rows($resultMyBooking)  > 0) {
        while ($rowBook = mysqli_fetch_array($resultMyBooking, MYSQLI_ASSOC)) {
        
        $tbody2 .= "<tr>
            <td>" . $rowBook['model'] . "</td>
            <td>" . $rowBook['price'] . "</td>
            </tr>
          ";}
        }

//php for the car pool
$sql = "SELECT * FROM cars ORDER BY available";
$result = mysqli_query($connect, $sql);
$tbody = ''; //this variable will hold the body for the table
if (mysqli_num_rows($result)  > 0) {
        while ($row2 = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if($row2['available']=='booked'){
        $tbody .= "<tr>
            <td>" . $row2['model'] . "</td>
            <td>" . $row2['price'] . "</td>
            <td>" . $row2['available'] . "</td>
            <td>no action possible
           </td>
            </tr>
          ";}
        else{
                $tbody .= "<tr>
                <td>" . $row2['model'] . "</td>
                <td>" . $row2['price'] . "</td>
                <td>Available</td>
                <td><a href='bookCar.php?id=". $row2['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Book</button></a>
               </td>
                </tr>
                <div class='mb-3'>";

            }}}

            //php contact form
            if($_SERVER["REQUEST_METHOD"] == 'POST'){ 
                $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // simple validation if you insert an email
                $msg = filter_var($_POST["msg"]); // simple validation if you insert a string
                //$message='';
                // mail function in php look like this  (mail(To, subject, Message, Headers, Parameters))
                //$headers = "FROM : ". $email . "\r\n";
                //$myEmail = "youremail@example.com";
                if($msg){
                    $sql = "INSERT INTO messages(user_email, message)
                    VALUES('$$email', '$msg')"; //insert query
                    $result = mysqli_query($connect, $sql); //trigger the query 
                    $message = ($result) ? "Message sent and saved to the database" : "there was an error";
                    echo "sent";
                }else {
                        echo "error";
                }

        }
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
        <legend class='h2'>My booking(s)</legend>

        <table class='table table-striped'>
            <thead class='table-success'>
                <tr>
                    <th>Car</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?= $tbody2?>
            </tbody>
        </table>
        <legend class='h2'>Our car pool</legend>

        <table class='table table-striped'>
            <thead class='table-success'>
                <tr>
                    <th>Car</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?= $tbody; ?>
            </tbody>
        </table>
        <legend class='h2'>Contact</legend>
        <form method="POST" class="container">
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="msg"></textarea>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Send</button>
                  </div>
         </form>
       <!-- <div id="booking">
       <a style="margin-top:15px" class="btn btn-success w-100" href="bookCar.php?id=<?php echo $_SESSION['user'] ?>">Book a car</a>
       </div> -->


    </div>
</body>
</html>