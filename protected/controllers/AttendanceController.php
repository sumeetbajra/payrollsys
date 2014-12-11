<?php

class AttendanceController extends Controller
{
	public $layout = '//layouts/column2';

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