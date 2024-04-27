<?php
// class security {
// 	public static function encrypt($input, $key='9856741230123654') {
// 		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
// 		$input = Security::pkcs5_pad($input, $size);
// 		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
// 		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
// 		mcrypt_generic_init($td, $key, $iv);
// 		$data = mcrypt_generic($td, $input);
// 		mcrypt_generic_deinit($td);
// 		mcrypt_module_close($td);
// 		$data = base64_encode($data);
// 		return $data;
// 	}

// 	private static function pkcs5_pad ($text, $blocksize) {
// 		$pad = $blocksize - (strlen($text) % $blocksize);
// 		return $text . str_repeat(chr($pad), $pad);
// 	}

// 	public static function decrypt($sStr, $sKey) {
// 		$decrypted= mcrypt_decrypt(
// 			MCRYPT_RIJNDAEL_128,
// 			$sKey,
// 			base64_decode($sStr),
// 			MCRYPT_MODE_ECB
// 		);
// 		$dec_s = strlen($decrypted);
// 		$padding = ord($decrypted[$dec_s-1]);
// 		$decrypted = substr($decrypted, 0, -$padding);
// 		return $decrypted;
// 	}
// }

// 9856741230123654
class Security {
    public static function encrypt($input, $key = '7895215780405209') {
        $method = 'AES-128-ECB';
        $output = openssl_encrypt($input, $method, $key, OPENSSL_RAW_DATA);
        return base64_encode($output);
    }

    public static function decrypt($sStr, $sKey) {
        $method = 'AES-128-ECB';
        $decrypted = openssl_decrypt(base64_decode($sStr), $method, $sKey, OPENSSL_RAW_DATA);
        return $decrypted;
    }
}


?>
