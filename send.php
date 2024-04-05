<?php
require_once 'connection.php';
require_once 'path/to/PHPMailer/src/PHPMailer.php';
require_once 'path/to/PHPMailer/src/SMTP.php';
require_once 'path/to/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

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

        // Retrieve customer's email from the booking
        $sql_email = "SELECT EMAIL FROM booking WHERE BOOK_ID = $bid";
        $result_email = mysqli_query($con, $sql_email);
        $row_email = mysqli_fetch_assoc($result_email);
        $customerEmail = $row_email['EMAIL'];

        // Send email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP host
            $mail->SMTPAuth   = true;
            $mail->Username   = 'gowthamiwttt123@gmail.com'; // Your Gmail address
            $mail->Password   = 'ibtc crrx kbxi vdep'; // Your Gmail password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465; // SMTP port

            //Recipients
            $mail->setFrom('gowthamiwttt123@gmail.com', 'Car Rentals');
            $mail->addAddress($customerEmail); // Recipient email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Payment Receipt for Booking ID: ' . $bid;
            $mail->Body    = '
                <html>
                <body>
                    <h2>Payment Receipt</h2>
                    <p><strong>Booking ID:</strong> ' . $bid . '</p>
                    <p><strong>Card Number:</strong> ' . $cardNo . '</p>
                    <p><strong>Expiry Date:</strong> ' . $expDate . '</p>
                    <p><strong>CVV:</strong> ' . $cvv . '</p>
                    <p><strong>Total Amount:</strong> ₹' . $price . '/-</p>
                </body>
                </html>
            ';
            $mail->AltBody = 'Payment Receipt' . "\r\n" .
                'Booking ID: ' . $bid . "\r\n" .
                'Card Number: ' . $cardNo . "\r\n" .
                'Expiry Date: ' . $expDate . "\r\n" .
                'CVV: ' . $cvv . "\r\n" .
                'Total Amount: ₹' . $price . '/-';

            $mail->send();
            echo '<script>alert("Receipt sent to customer\'s email successfully!")</script>';
            header("Location: cardetails.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo '<script>alert("No payment details found for this booking ID.")</script>';
        header("Location: cardetails.php");
    }
} else {
    echo '<script>alert("Invalid URL. Please provide a valid booking ID.")</script>';
    header("Location: cardetails.php");
}
?>