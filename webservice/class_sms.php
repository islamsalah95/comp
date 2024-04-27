<?php

if (!defined('clientid') && !defined('pass') && !defined('title')) {
    require SERVER_ROOT . '/protected/setting/smtp.php';
}


	 function validate_mobile($mobile_number){
		return preg_match('/^[0-9]{12}+$/', $mobile_number);
	}

	 function send_sms( $mobile, $sms ){
		if(isset($mobile) && $mobile != '' && isset($sms) && $sms != ''){
			$valid_num =validate_mobile($mobile);
			if($valid_num){
    $clientid = clientid;
	$spass = pass;
	$title = title;
    $msg = urlencode($sms); // URL encode the message

    $Surl = "https://api.goinfinito.me/unified/v2/send?clientid=$clientid&clientpassword=$spass&to=$mobile&from=$title&text=$msg";

    $curl_handle = curl_init();

    curl_setopt($curl_handle, CURLOPT_URL, $Surl);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLINFO_HEADER_OUT, true);

    $message = curl_exec($curl_handle);

    if ($message === false) {
        throw new Exception('Curl error: ' . curl_error($curl_handle));
    }

    // if (strpos($message, 'Success') !== false) {
    //     echo "SMS sent successfully to $mobile: $sms<br><br>";
    // } else {
    //     echo "Failed to send SMS to $mobile: $sms<br><br>";
    // }

			}

			
		}
	}
	





?>