<?php

require 'vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// lien mauvais il faut spécifier
$lien = "http://localhost:8080/page_referent.html";
$name = $_POST["nom"];
$name_ref = $_POST["nom_ref"];
$email = $_POST["mail"];
$subject = "Demande de réference de ".$name; 
$message = "Bonjour ".$name_ref.", ".$name." vous a envoyé une demande de réference sur Jeunes 6.4 merci de la remplir en
cliquant sur ce lien".$lien;

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.office365.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'jeunes.6.4@outlook.com';
  $mail->Password = 'w88YDP2F6zLMit5';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;
  

  // Set other email parameters (to, subject, message, headers)
  $mail->setFrom('jeunes.6.4@outlook.com');
  //destination
  $mail->addAddress($email);
  $mail->Subject = utf8_decode($subject);
  $mail->Body = utf8_decode($message);
  

  // Send the email
  $mail->send();

  
  echo "<script>if(confirm('Demande envoyé avec succès')){document.location.href='page_jeune_final.html'};</script>";
} catch (Exception $e) {
  echo "<script>if(confirm('Probleme lors de l'envoie du mail')){document.location.href='page_demande_reference.html'};</script>";
}

?>