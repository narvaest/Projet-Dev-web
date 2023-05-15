<?php

/*$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.sendgrip.net";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "Project_Dev_Web";
$mail->Password = "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";

/*$mail->setFrom($email, $name);
$mail->addAddress("dave@example.com", "Dave");*/

/*$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

header("Location: sent.html");*/

echo 'letssss gooo';

require 'vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo 'letssss gooo';


$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.sendgrid.net';
  $mail->SMTPAuth = true;
  $mail->Username = 'Project_Dev_Web';
  $mail->Password = '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';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;
  echo 'letssss gooo';


  // Set other email parameters (to, subject, message, headers)
  $mail->setFrom('test_project@myyahoo.com');
  //destination
  $mail->addAddress('test_project@aol.com');
  $mail->Subject = 'Thank you for your submission';
  $mail->Body = "Dear PAULINE,\n\nThank you for submitting the form. We will get back to you shortly.\n\nBest regards,\nYour Website Team";
  echo 'befletssss gooo';

  // Send the email
  $mail->send();
  echo 'after gooo';

  echo 'Thank you! An email has been sent to the client.';
} catch (Exception $e) {
  echo 'Oops! An error occurred while sending the email: ' . $mail->ErrorInfo;
}

?>