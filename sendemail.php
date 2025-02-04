<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If installed via Composer
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['number']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration for GoDaddy
        $mail->isSMTP();
        $mail->Host = 'smtpout.secureserver.net'; // GoDaddy's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@yourdomain.com'; // Your GoDaddy email
        $mail->Password = 'your-email-password'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
        $mail->Port = 587; // Port for GoDaddy SMTP

        // Sender and Recipient
        $mail->setFrom('your-email@yourdomain.com', 'Your Website');
        $mail->addAddress('purushothaman619997@gmail.com', 'Purushothaman');

        // Email Content
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->isHTML(true);
        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Service Requested:</strong> $subject</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        // Send Email
        if ($mail->send()) {
            echo "<script>
                    alert('Your message has been sent successfully!');
                    window.location.href = 'thank-you.html'; // Redirect to Thank You Page
                  </script>";
        } else {
            echo "<script>
                    alert('Error: Message could not be sent.');
                    window.history.back(); // Redirect back to the form
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('Mailer Error: {$mail->ErrorInfo}');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request.');
            window.history.back();
          </script>";
}
?>