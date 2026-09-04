<?php
// Configuration for PHPMailer SMTP Settings & Recipients
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Server settings untuk Email
$mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->isSMTP();
$mail->Host       = 'mail.suketdesa.id';
$mail->SMTPAuth   = true;
$mail->Username   = 'support@suketdesa.id';
$mail->Password   = 'rkeblq50PS!';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;

// Recipients
$mail->setFrom('support@suketdesa.id', 'Sistem Informasi Desa');
if (isset($alamatEmailAdmin) && !empty($alamatEmailAdmin)) {
    $mail->addAddress($alamatEmailAdmin);
}
?>
