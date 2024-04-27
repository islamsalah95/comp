<!--contact_us_form.php-->
<?php
    // if(isset($_POST["submit_contact"])) {

        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        
        $mail = new PHPMailer;
        $mail->SMTPDebug = 2;
        $mail->CharSet = 'UTF-8';
        $mail->Debugoutput = 'html';
        $mail->Host = 'mail.techsupflex.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "services@techsupflex.com";
        $mail->Password = "ddE@;((Q^(Ca";
        $mail->setFrom('services@techsupflex.com', 'Techsup Flex');
        $mail->addReplyTo('services@techsupflex.com', 'Techsup Flex');

        $mail->clearAllRecipients();

        $mail->Subject = '[TechsupFlex] Service Request';

        $message_data = '';         
        $message_data .= '<div style="width:100%;text-align:center;margin-bottom: 10px;">';
        $message_data .= '<img style="width:150px" src="' .SITE_URL. '/assets/main_frontend/images/logo-1-removebg-preview-294x122.png">';
        $message_data .= '</div>';
        $message_data .= '<div style="text-align:center;font-family: Cairo-Regular,Arial, sans-serif;">';
        $message_data .= '<h2>[TechsupFlex] New Service Request</h2>';
        $message_data .= '<h5>Check customer below data</h5>';
        $message_data .= '<br/><br/>';
        $message_data .= '<div style="clear: both;"></div>';
        $message_data .= '<div style="text-align:left;font-size: 1.2rem;line-height: 1.5;">';
        $message_data .= '<p><strong>Name: </strong>'.$name.'</p>';
        $message_data .= '<p><strong>Email: </strong>'.$email.'</p>';
        $message_data .= '<p><strong>phone: </strong>'.$phone.'</p>';
        $message_data .= '</div>';
        $message_data .= '</div>';
        
        $mail->msgHTML($message_data);
        $mail->addAddress("services@techsupflex.com");
        $mail_status = $mail->send();
         ?>

        <?php
    // }

?>