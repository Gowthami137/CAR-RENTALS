<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Receipt</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
      padding: 20px;
    }

    .receipt {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .receipt h2 {
      margin-bottom: 10px;
      color: #333;
    }

    .receipt p {
      margin: 5px 0;
      color: #555;
    }

    .receipt .info {
      margin-bottom: 20px;
    }

    .receipt .info p {
      font-weight: bold;
    }

    .receipt .info .highlight {
      color: #ff7200;
    }

    .receipt a {
      text-decoration: none;
      color: #007bff;
    }

    .receipt a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="receipt">
    <h2>Payment Receipt</h2>
    <?php
    require_once('connection.php');
    //session_start();
    
    if (isset($_GET['bid'])) {
      $bid = $_GET['bid'];
      $sql = "SELECT * FROM payment WHERE BOOK_ID = $bid";
      $result = mysqli_query($con, $sql);
      
      if (mysqli_num_rows($result) > 0) {
        $payment = mysqli_fetch_assoc($result);
        $cardNo = $payment['CARD_NO'];
        $expDate = $payment['EXP_DATE'];
        $cvv = $payment['CVV'];
        $price = $payment['PRICE'];
        
        echo '
        <div class="info">
          <p><span class="highlight">Booking ID:</span> ' . $bid . '</p>
          <p><span class="highlight">Card Number:</span> ' . $cardNo . '</p>
          <p><span class="highlight">Expiry Date:</span> ' . $expDate . '</p>
          <p><span class="highlight">CVV:</span> ' . $cvv . '</p>
          <p><span class="highlight">Total Amount:</span> ₹' . $price . '/-</p>
        </div>';
        
        // Link to send receipt to email
        echo '<p><a href="mail.php?bid=' . $bid . '">Send Receipt to Email</a></p>';
      } else {
        echo '<p>No payment details found for this booking ID.</p>';
      }
    } else {
      echo '<p>Invalid URL. Please provide a valid booking ID.</p>';
    }
    ?>
    <p><a href="cardetails.php">Back to Home</a></p>
  </div>
</body>
</html>
