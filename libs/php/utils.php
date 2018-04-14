<?php
class Utils{

	// send email using built in php mailer
	public function sendEmailViaPhpMail($from_name, $from_email, $send_to_email, $subject, $body){

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: {$from_name} <{$from_email}> \n";

		if(mail($send_to_email, $subject, $body, $headers)){
			return true;
		}else{
			echo "<pre>";
				print_r(error_get_last());
			echo "</pre>";
		}

		return false;

	}

	// get string slug, used for product names in URLs
	public function slugify($string, $separator='-'){

		setlocale(LC_ALL, 'en_US.UTF8');

		// remove double quote
		$string=str_replace("\"", "", $string);

		// remove single quote
		$string=str_replace("'", "", $string);

		// remove dots
		$string=str_replace(".", "", $string);

		// do the slug
		$accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
		$special_cases = array( '&' => 'and');
		$string = mb_strtolower( trim( $string ), 'UTF-8' );
		$string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
		$string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
		$string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
		$string = preg_replace("/[$separator]+/u", "$separator", $string);

		return $string;
	}

	// send email using php mailer library
	public function sendEmailViaPhpMailerLibrary($send_to_email, $subject, $body){

		// include the library
		require("libs/php/PHPMailer-master/PHPMailerAutoload.php");

		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		date_default_timezone_set('Etc/UTC');

		//Create a new PHPMailer instance
		$mail = new PHPMailer;

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		// $mail->SMTPDebug = 2;

		//Ask for HTML-friendly debug output
		// $mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		// set your from name here
		$from_name="Admin";

		// set your gmail address here
		$from_email="your@gmail.com";

		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = $from_email;

		// Password to use for SMTP authentication (gmail password)
		$mail->Password = "yourgmailpassw";

		//Set who the message is to be sent from
		$mail->setFrom($from_email, $from_name);

		//Set an alternative reply-to address
		$mail->addReplyTo($from_email, $from_name);

		//Set who the message is to be sent to
		// $mail->addAddress($send_to_email, 'John Doe');
		$mail->addAddress($send_to_email);

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		$mail->msgHTML($body);

		//Replace the plain text body with one created manually
		// $mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		// $mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if(!$mail->send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
			return false;
		}

		else {
			return true;
		}
	}

	function crypto_rand_secure($min, $max) {
		$range = $max - $min;
		if ($range < 0) return $min; // not so random...
		$log = log($range, 2);
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd >= $range);
		return $min + $rnd;
	}

	function getToken($length=32){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		for($i=0;$i<$length;$i++){
			$token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
		}
		return $token;
	}
}
?>
