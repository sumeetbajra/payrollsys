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
				'actions'=>array('create','update', 'admin', 'delete', 'departAttendanceReport', 'customAttendanceReport', 'getAttendance', 'uploadAttendance'),
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

	/**
	 * upload attendance data as csv
	 */
	public function actionuploadAttendance() {

		$model=new Attendance;
		$uidKey = 0;
		$arrangedData = [];
		$dateTimeKey = 0;

		if(isset($_POST['file']))
		{
			$file=CUploadedFile::getInstanceByName('csvfile');
  			// To validate
			if($file) {
				$transaction = Yii::app()->db->beginTransaction();
				$handle = fopen("$file->tempName", "r");
				$row = 1;
				$record = array();
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

					$data[0] = preg_split('/[\t]/', $data[0]); 

					if($row == 1){						
						for ($i=0; $i < sizeof($data[0]); $i++) { 
							$data[0][$i] = preg_replace("/[^a-zA-Z0-9\/:]+/", "", $data[0][$i]);
						}
						$data[0] = array_filter($data[0]);

						$uidKey = array_search('UID', $data[0]);
						$dateTimeKey = array_search('DateTime', $data[0]);
					}else {
						$attendanceDay = $data[0];
						
						for ($i=0; $i < sizeof($attendanceDay); $i++) { 
							$attendanceDay[$i] = preg_replace("/[^a-zA-Z0-9\/:]+/", "", $attendanceDay[$i]);
						}

						$a = array_filter($attendanceDay, function($val) { 
								return ($val || is_numeric($val));
							}
						);

						if(strlen($a[0]) != 0) {
							$uuid = base_convert($a[$uidKey],8,10);							
							$recordRow['staff'] = Staff::model()->findByAttributes(['uuid' => $uuid])->staff_id;
							$recordRow['datetime'] = strtotime($a[$dateTimeKey]);
							array_push($record, $recordRow);
						}
					}

					$row++;
				}
			}   

			$days = [];
			for ($i=0; $i < sizeof($record); $i++) { 
				if(!in_array($record[$i]['day'], $days)) {
					array_push($days, $record[$i]['day']);
				}
			}

			$sortByDate = [];

			for ($i=0; $i < sizeof($days); $i++) { 
				for ($j=0; $j < sizeof($record) ; $j++) { 
					if($record[$j]['day'] == $days[$i]) {
						$sortByDate[$days[$i]][$record[$j]['staff']] = [
							'time' => $record[$j]['datetime']
						];
					}
				}
			}

			echo "<pre>";
			print_r($sortByDate);
			exit;     

			$user = Staff::model()->findByAttributes(array('username'=>$username));
		if(!empty($user) && $user->password == hash('sha256', (hash('sha256', $user->created_date)).$this->password)){
			$attendance = Attendance::model()->findByAttributes(array('staff_id'=>$user->staff_id), array('order'=>'login DESC'));
			if(empty($attendance)){
				$attendance = new Attendance;
				$attendance->staff_id = $user->staff_id;
				$attendance->login = time();
				/*print_r($attendance->login);
				echo "<br>";
				print_r(Staff::model()->findByPk($user->staff_id)->office_start_time);
				exit;*/
				if($attendance->login <= strtotime(StaffOfficeTime::model()->findByAttributes(array('staff_id'=>$user->staff_id), array('order'=>'effective_date DESC'))->start_time)){
					$attendance->login_status = 'On time';
				}else{
					$attendance->login_status = 'Late';
				}
				$attendance->save();
				Yii::app()->user->setState('login_id', Yii::app()->db->getLastInsertId());
			}else{
				$date1 = date('Y-m-d', $attendance->login);
				if($date1 != date('Y-m-d', time())){
					$attendance = new Attendance;
					$attendance->staff_id = $user->staff_id;
					$attendance->login = time();
					if(time() <= strtotime(StaffOfficeTime::model()->findByAttributes(array('staff_id'=>$user->staff_id), array('order'=>'effective_date DESC'))->start_time)){
						$attendance->login_status = 'On time';
					}else{
						$attendance->login_status = 'Late';
					}
					/*echo "<pre>";
					print_r($attendance->getErrors());
					exit;*/
					$attendance->save();
					Yii::app()->user->setState('login_id', $attendance->id);
				}elseif(empty($attendance->logout)){
					Yii::app()->user->setState('login_id', $attendance->id);
				}
			}	           
		}  

		$this->render('uploadAttendance');
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