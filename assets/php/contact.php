<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './phpmailler/src/Exception.php';
require './phpmailler/src/PHPMailer.php';
require './phpmailler/src/SMTP.php';

if ($_POST) {
	$response = array();
	$nullDataCount = 0;

	$name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : $nullDataCount++;
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : $nullDataCount++;
	$subject = (isset($_POST['subject']) && !empty($_POST['subject'])) ? $_POST['subject'] : $nullDataCount++;

	$message = "<br>" . isset($_POST['message']) && !empty($_POST['message']) ? $_POST['message'] : $nullDataCount++;
	$message .= "<br><br><br> Adı Soyadı: $name <br>";
	$message .= "Email: $email <br>";
	$message .= "İp Adresi: " . $_SERVER['REMOTE_ADDR'] . "<br>";

	if ($nullDataCount != 0) {
		$response = array(
			'status' => "nullData",
			'message' => "Lütfen tüm alanları doldurunuz."
		);
		
		echo json_encode($response);
		die;
	}

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = "smtp";

	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = "tls";
	$mail->Port       = 587;
	$mail->Host       = "smtp.gmail.com";
	$mail->Username   = "loncademircisi@gmail.com";
	$mail->Password   = "aynenaynen123";

	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->addAddress('asosyalgenctvtr@gmail.com', 'Furkan ARTAR');
	$mail->setFrom('loncademircisi@gmail.com', 'Github.io');
	$mail->Subject = $subject;
	$mail->MsgHTML($message);

	$result = $mail->send();
	$messageSuccess = "E-Postanız başarıyla gönderildi.";
	$messageError = "E-Postanız gönderilemedi, lütfen furkanartar@protonmail.com üzerinden veya sosyal medya hesaplarım üzerinden benimle iletişime geçiniz.";
	
	$response = array(
		'status' => $result,
		'message' => $result ? $messageSuccess : $messageError,
	);

	echo json_encode($response);
}
