<?php

class StaffController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'loadGrades'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'changePassword', 'attendanceReport', 'attendanceStatistics', 'edit'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','create', 'delete', 'staffAllowance', 'viewAllowance', 'addAllowance', 'updateAllowance', 'SalarySheet', 'updateStaffAllowance', 'DeleteStaffAllowance', 'AttendanceDetail', 'printWeekAttendance', 'departWeeklyAttendance'),
				'users'=>array('admin', 'sanjay'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('staff_view',array(
			'model'=>Staff::model()->with('officeTime')->findByPk($id),
			'id'=>$id,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Staff;
		$officeTime = new StaffOfficeTime;
		$selfPf = new StaffSelfPf;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$designations=Designation::model()->findAll(array(
		    'select'=>'t.designation',
		    'group'=>'t.designation',
		    'distinct'=>true,
		));

		$array = array();
    
		    foreach ($designations as $key => $value) {
		        $array[$value->designation] = $value->designation;
		    }
		    $departments=Department::model()->findAll();

		$array1[] = 'Select department';
    
		    foreach ($departments as $key => $value) {
		        $array1[$value->department_id] = $value->department_name;
		    }

		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
			$model->join_date = strtotime($model->join_date);
			$model->designation_id = Designation::model()->findByAttributes(array('designation'=>strtolower($_POST['designation']), 'grade'=>$_POST['grades']))->id;
			$model->username = strtolower($model->fname);
			$model->created_date = time();
			$model->password = hash('sha256', (hash('sha256', $model->created_date)).'password');
			if($model->save()){
				$officeTime->attributes = $_POST['StaffOfficeTime'];
				$officeTime->staff_id = $model->staff_id;
				$officeTime->effective_date = date('Y-m-d H:i', time());
				$officeTime->save();
				$this->redirect(array('staffAllowance','id'=>$model->staff_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'officeTime'=>$officeTime,
			'array'=>$array,
			'array1'=>$array1,
		));
	}

	/**
	 * adds allowance to staff through ajax request and sends response
	 * @return [boolean] [true on success and false on failure]
	 */
	public function actionStaffAllowance($id){
		$transaction = Yii::app()->db->beginTransaction();
		$model = new StaffAllowance;
		$model1 = new Allowances;
		if(isset($_POST['allowance-btn'])){
			foreach ($_POST as $aid => $percentage) {
				if($id != 'allowance-btn'){
					$model = new StaffAllowance;
					$model->staff_id = $id;
					$model->allowance_id = $aid;
					$model->percentage = $percentage;
					$model->effective_date = date('Y-m-d H:i:m', time());
					if(!$model->save()){
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'The system encountered an error.');
						print_r($model->getErrors());
						exit;
						$this->redirect('/Staff/view/'.$id);
					}
				}
			}
			$transaction->commit();
		}
		$this->render('staffAllowance', array('model'=>$model, 'model1'=>$model1, 'id'=>$id));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		$model=$this->loadModel($id);
		$officeTime = StaffOfficeTime::model()->findByAttributes(array('staff_id'=>$id), array('order'=>'effective_date DESC'));
		if(empty($officeTime)){
			$officeTime = new StaffOfficeTime;
		}
		$designation = Designation::model()->findByPk($model->designation_id);
		$model->designation = $designation->designation;
		$model->grade = $designation->grade;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$designations=Designation::model()->findAll(array(
		    'select'=>'t.designation',
		    'group'=>'t.designation',
		    'distinct'=>true,
		));
		$array = array();
    
		    foreach ($designations as $key => $value) {
		        $array[$value->designation] = $value->designation;
		    }

		    $departments=Department::model()->findAll();

		$array1[] = 'Select department';
    
		    foreach ($departments as $key => $value) {
		        $array1[$value->department_id] = $value->department_name;
		    }
		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
			if(!empty($officeTime->startTime)){
			 	if($officeTime->startTime != $_POST['StaffOfficeTime']['startTime'] || $officeTime->endTime != $_POST['StaffOfficeTime']['endTime']){
					$officeTime->attributes = $_POST['StaffOfficeTime'];
					$officeTime->staff_id = $id;
					$officeTime->effective_date = date('Y-m-d H:i', time());
					$officeTime->save();
				}
			}else{
				$officeTime->attributes = $_POST['StaffOfficeTime'];
				$officeTime->staff_id = $id;
				$officeTime->effective_date = date('Y-m-d H:i', time());
				if($officeTime->save()){

				}else{
					print_r($officeTime->getErrors());
					exit;
				}
			}
			$model->join_date = strtotime($model->join_date);
			if (empty($_POST['designation']) && empty($_POST['grade'])){
				Yii::app()->user->setFlash('error', 'Designation and/or grade cannot be blank');
				$this->redirect(Yii::app()->createUrl('Staff/Update/'.$id));
			}
			$model->designation_id = Designation::model()->findByAttributes(array('designation'=>strtolower($_POST['designation']), 'grade'=>$_POST['grades']))->id;
			if($model->save()){
				Yii::app()->user->setFlash('success', 'The staff details has been updated successfully.');
				$this->redirect(array('admin','id'=>$model->staff_id));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'array'=>$array,
			'officeTime'=>$officeTime,
			'array1' => $array1,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = new Staff;
		$model->deactivateStaff($id);
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Staff');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Staff('search');
		$officeTime = new StaffOfficeTime;
		$model->unsetAttributes();  // clear any default values
		$designations=Designation::model()->findAll(array(
		    'select'=>'t.designation',
		    'group'=>'t.designation',
		    'distinct'=>true,
		));
		$array = array();
    
		    foreach ($designations as $key => $value) {
		        $array[$value->designation] = $value->designation;
		    }

		    $departments=Department::model()->findAll();

		$array1[] = 'Select department';
    
		    foreach ($departments as $key => $value) {
		        $array1[$value->department_id] = $value->department_name;
		    }
		if(isset($_GET['Staff'])){
			//echo "<pre>";
			//print_r($_GET);
			if(isset($_GET['Staff']['department_id']) && $_GET['Staff']['department_id'] == 0){
				$_GET['Staff']['department_id'] = '';
			}
			$model->attributes=$_GET['Staff'];
			$model->join_date = strtotime($model->join_date);
			if (!empty($_GET['designation']) && empty($_GET['grade'])){
				$model->designation_id = Designation::model()->findByAttributes(array('designation'=>strtolower($_GET['designation']), 'grade'=>$_GET['grades']))->id;
			}
		}

		$this->render('admin',array(
			'model'=>$model,
			'array'=>$array,
			'officeTime'=>$officeTime,
			'array1' => $array1,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Staff the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Staff::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Staff $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Allows users to edit their details
	 * @param  [int] $id id of the currently logged in user
	 */
	public function actionEdit($id){
		$model = Staff::model()->findByPk($id);
		if(isset($_POST['Staff'])){
			$model->attributes = $_POST['Staff'];
			$selfpf =  StaffSelfPf::model()->findByAttributes(array('staff_id'=>$id), array('order'=>'effective_date DESC'));
			if(empty($selfpf) ||  $selfpf->amount != $_POST['Staff']['selfPf']){
				$selfpf = new StaffSelfPf;
				$selfpf->staff_id = $id;
				$selfpf->amount = $_POST['Staff']['selfPf'];
				$selfpf->effective_date = date('Y-m-d H:i:m', time());
				if(!$selfpf->save()){
					print_r($selfpf->getErrors());
					exit;
				}
			} 
			$rand = rand(0,9999);
                		$uploadedFile = CUploadedFile::getInstance($model,'profile_pic');
                		$fileName = "{$rand}-{$uploadedFile}";
                		if(!empty($_FILES['Staff']['name']['profile_pic'])){
                			$model->profile_pic = $fileName;
                		}else{
                			$model1 = Staff::model()->findByPk($id); 
                			$model->profile_pic = $model1->profile_pic;
                		}
 			$model->contact = $_POST['Staff']['contact'];
                		if($model->save()){
                			if(!empty($uploadedFile)){
                				$uploadedFile->saveAs(Yii::app()->basePath.'/../images/user-pics/'.$fileName);
                				$image = new EasyImage(Yii::app()->basePath.'/../images/user-pics/'.$fileName);
                				$image->resize(500, 500);
                				$image->crop(300, 300);
					$image->save(Yii::app()->basePath.'/../images/user-pics/'.$fileName);
                			}
                			Yii::app()->user->setFlash('success', 'User details has been edited successfully.');
				$this->redirect(Yii::app()->createUrl('Site'));
			}
		}
		$this->render('edit', array('model'=>$model));
	}

	public function actionloadGrades(){
		$data=Designation::model()->findAllByAttributes(array('designation'=>$_POST['desig']));
 		$data=CHtml::listData($data,'grade','grade');
   		foreach($data as $value=>$city_name)
   		echo CHtml::tag('option', array('value'=>$value),CHtml::encode($city_name),true);
	}

	public function actionAttendanceReport(){
		$this->layout = "//layouts/column2";
		$month = array(
			'' => '--Select a month',
			'1' => 'January',
			'2' => 'Febrauary',
			'3' => 'March',
			'4' => 'April',
			'5' => 'May',
			'6' => 'June',
			'7' => 'July',
			'8' => 'August',
			'9' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);
		$year = array(''=>'--Select a year--');
		for ($i=1984; $i <= date('Y', time()); $i++) { 
			$year[$i] = $i;
		}
		$this->render('../attendance/attendanceCalendar', array('months'=>$month, 'year'=>$year));
	}

	public function actionAttendanceStatistics($id = 0){
		if($id == 0){
			$id = Yii::app()->session['uid'];
		}
		$attendance = Attendance::model()->findAllByAttributes(array('staff_id'=>$id));
		$this->render('../attendance/attendanceReports', array('attendance'=>$attendance, 'id'=>$id));
	}

	public function actionAttendanceDetail($id = 0){
		if($id == 0){
			$id = Yii::app()->session['uid'];
		}
		$attendance = Attendance::model()->findAllByAttributes(array('staff_id'=>$id));
		$this->render('../attendance/attendanceDetail', array('attendance'=>$attendance, 'id'=>$id));
	}

	/**
	 * generates pdf of the weekly attendance report for a staff
	 * @param  integer $id id of the staff
	 */
	public function actionPrintWeekAttendance($id = 0){
		$model = new Attendance;
		$attendance = $model->thisWeekSearch1($id);
		$mPDF1 = Yii::app()->ePdf->mpdf();		
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
		$mPDF1->WriteHTML($this->renderPartial('../attendance/weeklyAttendancepdf', array('id'=>$id, 'model'=>$model, 'attendances'=>$attendance), true, true));
		$mPDF1->Output();
	}

	/**
	 * generates pdf of the weekly attendance report of a department
	 * @param  integer $id department id
	 */
	public function actionDepartWeeklyAttendance($id = 0){
		$model = new Attendance;
		if($id == 0){
			$id = Yii::app()->session['depart'];
		}
		$attendance = $model->departWeeklyAttendance($id);
		$mPDF1 = Yii::app()->ePdf->mpdf();		
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
		$mPDF1->WriteHTML($this->renderPartial('../attendance/weeklyAttendancepdf', array('id'=>$id, 'model'=>$model, 'attendances'=>$attendance), true, true));
		$mPDF1->Output();
	}

	/**
	 * Display all the allowances allocated to the staff
	 * @param  [int] $id [id of the staff]
	 */
	public function actionViewAllowance($id){
		$model = new StaffAllowance;
		$allowances = $model->getStaffAllowances($id);
		$this->render('viewAllowance', array('id'=>$id, 'allowances'=>$allowances));
	}

	public function actionAddAllowance(){
		if(isset($_GET['allowance'])){
			$model = new StaffAllowance;
			$allowance = (int) $_GET['allowance'];
			$percentage = $_GET['percentage'];
			$model->staff_id = $_GET['id'];
			$model->allowance_id = $allowance;
			$model->percentage = $percentage;
			$model->effective_date = date('Y-m-d H:i:m', time());
			if($model->save()){
				echo "true";
			}else{
				echo "false";
			}
		}
	}

	public function actionSalarySheet(){	
		$this->layout = "//layouts/column1";
		$staffs = '';
		$model = new Staff;
		$depart = '';
		if(isset($_POST['depart'])){
			$staffs = Staff::model()->findAllByAttributes(array('department_id'=>$_POST['depart'], 'active'=>'1'));
			$depart = $_POST['depart'];
		}
		$this->render('salarySheet', array('staffs'=>$staffs, 'model'=>$model, 'depart'=>$depart));

	}

	public function actionUpdateStaffAllowance(){
		if(isset($_GET['id']) && isset($_GET['rate'])){
			$staffAllowance = StaffAllowance::model()->findByPk($_GET['id']);
			/*echo "<pre>";
			print_r($staffAllowance);
			exit;*/
			if($staffAllowance->percentage != $_GET['rate']){
				$allowance = new StaffAllowance;
				$allowance->staff_id = $staffAllowance->staff_id;
				$allowance->allowance_id = $staffAllowance->allowance_id;
				$allowance->percentage = $_GET['rate'];
				$allowance->effective_date = date('Y-m-d H:i:m', time());
				if($allowance->save()){
					echo "true";
				}else{
					echo "false";
				}
			}
		}
	}

	public function actionDeleteStaffAllowance($id){
		$allowance = new StaffAllowance;
		$staffAllowance = StaffAllowance::model()->findByPk($_GET['id']);
		$allowance->staff_id = $staffAllowance->staff_id;
		$allowance->allowance_id = $staffAllowance->allowance_id;
		$allowance->percentage = 0;
		$allowance->effective_date = date('Y-m-d H:i:m', time());
		if($allowance->save()){
			Yii::app()->user->setFlash('success', 'Allowance deleted succesfully');
			$this->redirect(Yii::app()->createUrl('/Staff/viewAllowance/'.$staffAllowance->id));
		}
	}
}
