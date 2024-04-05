<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKING STATUS</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('contus.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Keeps the background image fixed while scrolling */
            color: white; 
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }

        .greeting {
            font-weight: bold;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .box {
            margin: 0 auto; /* Center the box horizontally */
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
           
        }

        .box .content {
            font-size: 18px;
            color: white;
        }

        .button {
            background: #ff7200;
            border: none;
            font-size: 18px;
            border-radius: 10px;
            cursor: pointer;
            color: #fff;
            transition: 0.4s ease;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 30px;
        }

        .button a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        @media (min-width: 576px) {
            .box {
                max-width: 500px; /* Set maximum width of the box */
            }
        }
    </style>
</head>
<body>

    <?php
        require_once('connection.php');
        session_start();
        $email = $_SESSION['email'];

        $sql = "select * from booking where EMAIL='$email' order by BOOK_ID DESC LIMIT 1";
        $name = mysqli_query($con, $sql);
        $rows = mysqli_fetch_assoc($name);
        if ($rows == null) {
            echo '<script>alert("THERE ARE NO BOOKING DETAILS")</script>';
            echo '<script>window.location.href = "cardetails.php";</script>';
        } else {
            $sql2 = "select * from users where EMAIL='$email'";
            $name2 = mysqli_query($con, $sql2);
            $rows2 = mysqli_fetch_assoc($name2);
            $car_id = $rows['CAR_ID'];
            $sql3 = "select * from cars where CAR_ID='$car_id'";
            $name3 = mysqli_query($con, $sql3);
            $rows3 = mysqli_fetch_assoc($name3);
        ?>

        <div class="container py-5">
            <div class="greeting">HELLO! <?php echo $rows2['FNAME']." ".$rows2['LNAME']?></div>

            <div class="box mx-auto">
                <div class="content">
                    <h1 class="text-center">BOOKING STATUS</h1>
                    <p>CAR NAME: <?php echo $rows3['CAR_NAME']?></p>
                    <p>NO OF DAYS: <?php echo $rows['DURATION']?></p>
                    <p>BOOKING STATUS: <?php echo $rows['BOOK_STATUS']?></p>
                </div>
                <a href="cardetails.php" class="btn button">Go to Home</a>
            </div>
        </div>

    <?php } ?>

    <!-- Bootstrap JS, Popper.js, and jQuery (for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
