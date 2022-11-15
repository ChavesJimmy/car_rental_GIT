<?php
session_start();

require_once 'components/db_connect.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = {$id}";
    $sql2 = "SELECT * FROM cars";
    $result = mysqli_query($connect, $sql);
    $result2 = mysqli_query($connect,$sql2);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $data2 = mysqli_fetch_assoc($result2);
        $user= $data['first_name'];
        $resultSup = mysqli_query($connect, "SELECT * FROM cars");
        $car=$data2['model'];
        $available= $data2['available'];
        $resultBook = mysqli_query($connect, $sql2);
        $bookList = "";
        if  (mysqli_num_rows($resultBook) > 0) {
            while ($row = $resultBook->fetch_array(MYSQLI_ASSOC)) {
                if ($row['model'] == $available) {
                    $bookList .= "<option selected value='{$row['model']}'>{$row['model']}</option>";
                } else  {
                    $bookList .= "<option value='{$row['model']}'>{$row['model']}</option>" ;
                }
            }
        } else {
            $supList = "<li>There are no cars registered</li>";
        }

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
        <legend class='h2'>booking request from <?php echo $user ?></legend>
        <form action="actions/a_book.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Car</th>
                    <td><select class="form-select" type="number" name="fk_car" placeholder="Car" value="<?php echo $bookCar ?>">
                    <?= $bookList ?>
                </select></td>
                </tr>

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