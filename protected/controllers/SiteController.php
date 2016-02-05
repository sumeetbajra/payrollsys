<?php
// $time = time();
// print_r($time);
// echo "<br>";
// die(hash('sha256', (hash('sha256', $time)).'password'));
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = '//layouts/column2';
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function filters()
	{
	     return array(
	         'accessControl', // perform access control for CRUD operations
	         'postOnly + delete', // we only allow deletion via POST request
	     );
	}

	    /**
	     * Specifies the access control rules.
	     * This method is used by the 'accessControl' filter.
	     * @return array access control rules
	     */
	    public function accessRules()
	    {
	    	$superadmins = Staff::model()->findAllByAttributes(array('role'=>'superadmin'), array('select'=>'username'));
	    	foreach ($superadmins as $value) {
	    		$superadmin[] = $value->username;
	    	}
	        return array(
	            array('allow',  // allow all users to perform 'index' and 'view' actions
	                'actions'=>array('login','logout', 'checkUser'),
	                'users'=>array('*'),
	            ),
	            array('allow', // allow authenticated user to perform 'create' and 'update' actions
	                'actions'=>array('create','update','index','view','admin','delete','contact','error','page','staffDetails', 'AttendanceReport', 'test', 'Pdfmail','Pdfdesign','Searchformail','Viewdetail', 'settings', 'changePassword', 'changePasswordAjax', 'forecast', 'getforecast'),
	                'users'=>array('@'),
	            ),
	            array('allow', // allow admin user to perform 'admin' and 'delete' actions
	                'actions'=>array('admin','delete', 'DepartAttendanceReport', 'changePf'),
	                'users'=> $superadmin
	            ),
	            array('deny',  // deny all users
	                'users'=>array('*'),
	            ),
	        );
	    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = new Staff;
		$user = Staff::model()->findByPk(Yii::app()->session['uid']);
		$attendance = Attendance::model()->findByAttributes(array('staff_id'=>Yii::app()->session['uid']), array('order'=>'login DESC'));
		$month = date('F', time());
		$firstday = strtotime( 'first day of ' . date('F Y'));
		$lastday = strtotime( 'last day of ' . date('F Y'));
		$present = count(Attendance::model()->findAllByAttributes(array('staff_id'=>Yii::app()->session['uid']), 'login > "' . $firstday . '"AND logout < "' . $lastday . '"'));
		$late = count(Attendance::model()->findAllByAttributes(array('staff_id'=>Yii::app()->session['uid'], 'login_status'=>'Late'), 'login > "' . $firstday . '"AND logout < "' . $lastday . '"'));
		$early = count(Attendance::model()->findAllByAttributes(array('staff_id'=>Yii::app()->session['uid'], 'logout_status'=>'Early'), 'login > "' . $firstday . '"AND logout < "' . $lastday . '"'));
		$ontime = count(Attendance::model()->findAllByAttributes(array('staff_id'=>Yii::app()->session['uid'], 'login_status'=>'On time'), 'login > "' . $firstday . '"AND logout < "' . $lastday . '"'));
		$absent = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) - $present;
		$this->render('index', array('user'=>$user, 'attendance'=>$attendance, 'month'=>$month, 'late'=>$late, 'early'=>$early, 'ontime'=>$ontime, 'absent'=>$absent));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/login';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->createUrl('/Site/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$time = time();
		$user = Attendance::model()->findByPk(Yii::app()->user->getState('login_id'));
		$userLogoutTime = StaffOfficeTime::model()->findByAttributes(array('staff_id'=>Yii::app()->session['uid']), array('order'=>'effective_date DESC'))->end_time;
		if(empty($user->logout) && !empty($user)){
			$user->logout = $time;
			if($time <=  strtotime($userLogoutTime)){
				$user->logout_status = 'Early';
			}else{
				$user->logout_status = 'On time';
			}
			$user->save(false);
		}
		Yii::app()->user->logout();		
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionStaffDetails(){
		$this->render('staffDetails', array());
	}

	public function actionAttendanceReport(){
		$this->render('sampleForm');
	}

	/**
	 * Displays various settings options for the site
	 */
	public function actionSettings(){
		$this->render('settings');
	}

	public function actionChangePassword(){
		if(isset($_GET['password'])){
			$password = Staff::model()->findByPk(Yii::app()->session['uid'])->password;
			$time  = Staff::model()->findByPk(Yii::app()->session['uid'])->created_date;
			$ePassword = hash('sha256', (hash('sha256', $time)).$_GET['password']);
			if($password == $ePassword){
				echo "true";
			}else{
				echo "false";
			}
		}
	}

	public function actionChangePasswordAjax(){
		if(isset($_GET['password'])){
			$model = Staff::model()->findByPk(Yii::app()->session['uid']);
			$password = $model->password;
			$time  = Staff::model()->findByPk(Yii::app()->session['uid'])->created_date;
			$ePassword = hash('sha256', (hash('sha256', $time)).$_GET['password']);
			$model->password = $ePassword;
			if($model->save()){
				Yii::app()->user->setFlash('success', 'Your password has been changed successfully');
				echo "true";
			}else{
				echo "false";
			}
		}	
	}

	public function actionCheckUser(){
		if(isset($_GET['username'])){
			$model = Staff::model()->findByAttributes(array('username'=>$_GET['username']));
			if(!empty($model)){
				echo $model->email;
			}else{
				echo "false";
			}
		}
	}

	public function actionChangePf(){
		$pf = PayrollPf::model()->findByAttributes(array(), array('order'=>'effective_date DESC'));
		$pfc = PfContribution::model()->findByAttributes(array(), array('order'=>'effective_date DESC'));
		if(empty($pf)){
			$pf = new PayrollPf;
		}
		if(empty($pfc)){
			$pfc = new PfContribution;
		}
		if(isset($_POST['PayrollPf']) && isset($_POST['PfContribution'])){
			if(empty($pf) || $pf->pf_percent != $_POST['PayrollPf']['pf_percent']){
				$pf = new PayrollPf;
				$pf->pf_percent = $_POST['PayrollPf']['pf_percent'];
				$pf->effective_date = date('Y-m-d H:i:m', time());
				if(!$pf->save()){
					print_r($pf->getErrors());
					exit;
				}
			}
			if(!empty($pfc) || $pfc->rate != $_POST['PfContribution']['rate']){
				$pfc = new PfContribution;
				$pfc->rate = $_POST['PfContribution']['rate'];
				$pfc->effective_date = date('Y-m-d H:i:m', time());
				if(!$pfc->save()){
					print_r($pfc->getErrors());
					exit;
				}
			}
				Yii::app()->user->setFlash('success', 'Provident fund rates changed successfully.');
				$this->redirect(Yii::app()->createUrl('/Site/Settings'));
		}
		$this->render('changePf', array('pf'=>$pf, 'pfc'=>$pfc));
	}

	
}