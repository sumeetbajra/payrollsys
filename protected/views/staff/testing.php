<?php require Yii::app()->baseUrl . '/../assets/PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.ntc.net.np';  // Specify main and backup SMTP servers
//$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'sbajracharya@mdevsolutions.com';                 // SMTP username
$mail->Password = 'nazionale55';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to
$mail->SMTPDebug = 1;
$mail->From = 'sumit@example.com';
$mail->FromName = 'Third Pole Connects';
$mail->addAddress('sumeetbajra@gmail.com');               // Name is optional

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML
//generate token

$token = md5(uniqid(mt_rand(), true));

$mail->Subject = 'Here is the subject';
$mail->Body = 'Dear Sumit,<br>You requested to change your username/password for the payroll and attendance system. Please follow this link to change your username/password.<br>http://localhost/test/Staff/changePassword?token='.$token.'<br>If this wasn\'t you, please ignore this message.<br>Thank you!!<br>';
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	$staff = Staff::model()->findByPk(Yii::app()->session['uid']);
	$staff->token = $token;
	$staff->save();
}

?>