<?php
// Configuration for PHPMailer SMTP Settings & Recipients

// Server settings untuk Email
$mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_OFF;
$mail->isSMTP();
$mail->Host       = 'mail.suketdesa.id';
$mail->SMTPAuth   = true;
$mail->Username   = 'support@suketdesa.id';
$mail->Password   = 'rkeblq50PS!';
$mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;

// Recipients
$mail->setFrom('support@suketdesa.id', 'Sistem Informasi Desa');
if (isset($alamatEmailAdmin) && !empty($alamatEmailAdmin)) {
    $mail->addAddress($alamatEmailAdmin);
}
?>
