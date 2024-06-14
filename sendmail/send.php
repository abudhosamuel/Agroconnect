<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload.php

// Create a new PHPMailer instance
$mail = new PHPMailer(true); // true enables exceptions

try {
    // Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'samuelabudho20@gmail.com'; // SMTP username
    $mail->Password = 'pbch kunn trqb tdil'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom('your_email@gmail.com', 'Agroconnect');
    $mail->addAddress('recipient@example.com', 'Recipient Name'); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Subject Here';
    $mail->Body = 'Email body here';

    // Send the email
    $mail->send();
    echo 'Email has been sent';
} catch (Exception $e) {
    echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
}
?>