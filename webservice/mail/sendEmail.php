<?php
// Include the PHPMailer Autoload file
require SERVER_ROOT . '/webservice/mail/PHPMailer/src/Exception.php';
require SERVER_ROOT . '/webservice/mail/PHPMailer/src/PHPMailer.php';
require SERVER_ROOT . '/webservice/mail/PHPMailer/src/SMTP.php';
if (!defined('Host') || !defined('SMTPAuth') || !defined('Username') || !defined('Password')) {
    require SERVER_ROOT . '/protected/setting/smtp.php';
}

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($message ,$recipientEmail=null,$subject=null , $successMessage="Email has been sent successfully!"){
    
// Email configuration
$senderEmail = "noreply@techsupflex.com";



// Server settings
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = Host;
    $mail->SMTPAuth   = SMTPAuth;
    $mail->Username   = Username;
    $mail->Password   = Password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = Port; // Use 465 for SMTPS (deprecated) or 587 for SMTP with TLS
//     $mail->SMTPDebug = 2;
// 	$mail->CharSet = 'UTF-8';
// 	$mail->Debugoutput = 'html';

    // Recipients
    $mail->setFrom($senderEmail, 'Techsup Flex');
    $mail->addAddress($recipientEmail);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    // Send email
    $mail->send();
    echo '<div style="text-align: center; margin-top: 100px;">
    <div class="alert alert-success" style="display: inline-block;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        '  .$successMessage . '
    </div>
</div>';
        } catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
}
?>
