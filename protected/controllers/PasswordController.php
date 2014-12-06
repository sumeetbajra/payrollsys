<?php

class PasswordController extends Controller
{

	public function actionForgotPassword($email){
		require Yii::app()->baseUrl . '/../assets/PHPMailer-master/PHPMailerAutoload.php';
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

		$mail->Subject = 'Password reset';
		$staff = Staff::model()->findByAttributes(array('email'=>$email));
		$mail->Body = 'Dear ' . $staff->fname . ',<br><br>You requested to change your password for the payroll and attendance system. Please follow this link to change your username/password.<br>http://localhost/test/Password/changePassword?token='.$token.'<br>If this wasn\'t you, please ignore this message.<br><br>Thank you!!<br>Third Pole Connects';
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			$staff->token = $token;
			if($staff->save()){
				Yii::app()->user->setFlash('success', 'Password reset link has been sent to your email address.');
				$this->redirect(Yii::app()->createUrl('Site/login'));
			}
		}
	}

	public function actionChangePassword($token){
		$model = Staff::model()->findByAttributes(array('token'=>$token));
		if(isset($_GET['token'])){
			if(isset($_POST['Staff'])){
				if($_POST['Staff']['password'] == $_POST['password']){
					$time  = $model->created_date;
					$password = hash('sha256', (hash('sha256', $time)).$_POST['Staff']['password']);
					$model->password = $password;
					if($model->save()){
						Yii::app()->user->setFlash('success', 'Password changed successfully');
						$model->token = NULL;
						$model->save();
						$this->redirect(Yii::app()->createUrl('Site/login'));
					}	
				}else{
					$model->addError('password', 'Passwords do not match. Try again');
				}
			}
			if($model->token === $_GET['token']){
				$this->render('../staff/changePassword', array('model'=>$model));
			}else{
				echo "Sorry, your token has expired";
			}
		}
	}


	
}
