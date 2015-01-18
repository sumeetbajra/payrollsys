<?php

class AttendanceController extends Controller
{
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
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
	    	$excos = Staff::model()->findAllByAttributes(array('role'=>'exco'), array('select'=>'username'));
	    	foreach ($excos as $value) {
	    		$exco[] = $value->username;
	    	}
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'admin', 'delete', 'departAttendanceReport', 'customAttendanceReport', 'getAttendance'),
				'users'=>$superadmin,
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'admin', 'delete', 'departAttendanceReport', 'customAttendanceReport', 'getAttendance'),
				'users'=>$exco,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionDepartAttendanceReport(){
		$model = new Attendance;
		$departs = CHtml::listData(Department::model()->findAll(), 'department_id', 'department_name');
		$departId = 0;
		if(isset($_GET['depart'])){
			$departId = (int) $_GET['depart'];
			Yii::app()->session['depart'] = (int) $_GET['depart'];
		}
		$this->render('departAttendanceReport', array('model'=>$model, 'departs'=>$departs, 'departId'=>$departId));
	}

	public function actionCustomAttendanceReport(){
		$staffs = CHtml::listData(Staff::model()->findAll(), 'staff_id', 'fullName');
		$model = new Attendance;
		$attendance = $model->thisWeekSearch1();
		if(isset($_GET['staff']) || isset($_GET['from_date']) || isset($_GET['to_date'])){
			$id = (isset($_GET['staff']) ? (int) $_GET['staff'] : 0);
			$from = (isset($_GET['from_date']) ? strtotime($_GET['from_date']) : 0);
			$to = (isset($_GET['to_date']) ? strtotime($_GET['to_date']) : 0);
			Yii::app()->session['id'] = $id;
			Yii::app()->session['from'] = $from;
			Yii::app()->session['to'] = $to;
			$attendance = $model->thisWeekSearch1($id, $from, $to);
		}else{
			$attendance = new CArrayDataProvider(array());
		}
		$this->render('customAttendanceReport', array('model'=>$model, 'staffs'=>$staffs, 'attendance'=>$attendance));
	}

	/**
	 * gets attendance i.e. login and logout time of a staff based on ajax request.
	 * @return [json] [login and logout time of staff]
	 */
	public function actiongetAttendance(){
		if(isset($_GET)){
			$id = (int) $_GET['uid'];
			$date = $_GET['date'];
			/*print_r($date >= date('Y-m-d', time()));
			exit;*/
			$attendance = Attendance::model()->findByAttributes(array('staff_id'=>$id), "FROM_UNIXTIME(login, '%Y-%m-%d') = '$date'");
			if($date >= date('Y-m-d', time())){
				$response['errors'] = 'You cannot edit attendance for this day.';
			}elseif(empty($attendance)){
				$response['new'] = 'new';
			}elseif($id == Yii::app()->session['uid']){
				$response['errors'] = 'You cannot edit you own attendance.';
			}elseif(!empty($attendance->login)){
				$response['login'] = date('H:i', $attendance->login);
				$response['aid'] = $attendance->id;
				$response['logout'] = ((empty($attendance->logout)) ? '' : date('H:i', $attendance->logout));
			}
			echo json_encode($response);
		}
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}