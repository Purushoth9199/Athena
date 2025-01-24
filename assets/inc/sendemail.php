<?php

// Define constants for recipient details
define("RECIPIENT_NAME", "Athena Business Solutions");
define("RECIPIENT_EMAIL", "info@athenabizsolution.com");

// Read and sanitize form values
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$senderEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$services = filter_input(INPUT_POST, 'services', FILTER_SANITIZE_STRING);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Construct email subject and body
$mail_subject = 'A contact request sent by ' . $name;

$body = "Name: $name\r\n";
$body .= "Email: $senderEmail\r\n";
if ($phone) $body .= "Phone: $phone\r\n";
if ($services) $body .= "Services: $services\r\n";
if ($subject) $body .= "Subject: $subject\r\n";
if ($address) $body .= "Address: $address\r\n";
if ($website) $body .= "Website: $website\r\n";
$body .= "Message:\r\n$message";

// Send the email
if ($name && $senderEmail && $message) {
    $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
    $headers = "From: $name <$senderEmail>\r\n";
    $headers .= "Reply-To: $senderEmail\r\n";

    if (mail($recipient, $mail_subject, $body, $headers)) {
        echo "<div class='inner success'><p class='success'>Thanks for contacting us. We will contact you ASAP!</p></div>";
    } else {
        echo "<div class='inner error'><p class='error'>Something went wrong while sending your message. Please try again later.</p></div>";
    }
} else {
    echo "<div class='inner error'><p class='error'>Please fill in all required fields and try again.</p></div>";
}

?>
