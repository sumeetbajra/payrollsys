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