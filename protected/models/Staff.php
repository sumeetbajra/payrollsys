<?php

/**
 * This is the model class for table "staff".
 *
 * The followings are the available columns in table 'staff':
 * @property integer $staff_id
 * @property string $fname
 * @property string $lname
 * @property string $address
 * @property string $contact
 * @property string $username
 * @property string $password
 * @property integer $department_id
 * @property integer $designation_id
 * @property integer $join_date
 * @property integer $office_start_time
 * @property integer $office_end_time
 * @property string $email
 * @property string $profile_pic
 * @property integer $verified_email
 * @property string $token
 * @property integer $created_date
 */
class Staff extends CActiveRecord
{
	public $designation, $grade, $repassword, $start_time, $end_time, $selfPf;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'staff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fname, lname, address, contact, username, password, department_id, designation_id, join_date, email, created_date, marital_status', 'required'),
			array('department_id, designation_id, join_date, verified_email, created_date', 'numerical', 'integerOnly'=>true),
			array('fname, lname, address, contact, username, password, email', 'length', 'max'=>100),
			array('profile_pic', 'length', 'max'=>200),
			array('token', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('staff_id, fname, lname, address, marital_status, contact, username, password, department_id, designation_id, join_date, email, profile_pic, verified_email, token, created_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'depart' => array(self::BELONGS_TO, 'Department', 'department_id'),
			'officeTime' => array(self::HAS_MANY, 'StaffOfficeTime', 'staff_id'),
			'designation' =>array(self::BELONGS_TO, 'Designation', 'designation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'staff_id' => 'Staff',
			'fname' => 'Fname',
			'lname' => 'Lname',
			'address' => 'Address',
			'contact' => 'Contact',
			'marital_status'=>'Marital Status',
			'username' => 'Username',
			'password' => 'Password',
			'department_id' => 'Department',
			'designation_id' => 'Designation',
			'join_date' => 'Join Date',
			'email' => 'Email',
			'profile_pic' => 'Profile Pic',
			'verified_email' => 'Verified Email',
			'token' => 'Token',
			'created_date' => 'Created Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('staff_id',$this->staff_id);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('lname',$this->lname,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('marital_status',$this->marital_status,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('designation_id',$this->designation_id);
		$criteria->compare('join_date',$this->join_date);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('profile_pic',$this->profile_pic,true);
		$criteria->compare('verified_email',$this->verified_email);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('active','1', true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function deactivateStaff($id){
		$model = Staff::model()->findByPk($id);
		$model->active = 0;
		if($model->save()){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * method to get the self pf amount of a staff in a given month
	 * @param  [int] $id   staff id
	 * @param  [string] $date [date ]
	 * @return [type]       [description]
	 */
	public function getSelfPf($id, $date){
		$selfPf = StaffSelfPf::model()->findByAttributes(array('staff_id'=>$id), array('order'=>'id DESC'), 'month(effective_date) <= "'.date('m', $date) . '" AND year(effective_date) <= "' . date('y', $date) . '"');
		if(!empty($selfPf)){
			return $selfPf->amount;
		}else{
			return "0";
		}
	}

	public function getPf($date){
		$pf = PayrollPf::model()->findByAttributes(array(), array('order'=>'id DESC'), 'month(effective_date) <= "'.date('m', $date) . '" AND year(effective_date) <= "' . date('y', $date) . '"');
		if(!empty($pf)){
			return $pf->pf_percent;
		}else{
			return "0";
		}
	}

	public function getPfc($date){
		$pfc = PfContribution::model()->findByAttributes(array(), array('order'=>'effective_date DESC'), 'month(effective_date) <= "'.date('m', $date) . '" AND year(effective_date) <= "' . date('y', $date) . '"');
		if(!empty($pfc)){
			return $pfc->rate;
		}else{
			return "0";
		}
	}

	public function getAllowances($id, $allowance, $date){
		$allowances = StaffAllowance::model()->findAllByAttributes(array('staff_id'=>$id), array('group'=>'allowance_id'), 'effective_date <= "'.date('Y-m-d H:i:m', $date) . '" AND percentage != 0');
		$year = date('Y', $date);
		$month = date('m', $date);
		//foreach ($allowances as $key => $allowance) {
			$sql = "SELECT allowance_id, percentage FROM staff_allowance WHERE allowance_id = '".$allowance."' AND staff_id = '".$id."' AND year(effective_date) <= '".$year."' AND month(effective_date) <= '".$month."' ORDER BY id DESC";
			//$sql = "SELECT allowance_id, percentage FROM staff_allowance WHERE allowance_id = '1' AND staff_id = '12' AND year(effective_date) <= '2014' AND month(effective_date) <= '11' ORDER BY effective_date DESC";
			$result = Yii::app()->db->createCommand($sql)->queryRow();
		//}
		if(!empty($result['percentage'])){
			return $result['percentage'];
		}else{
			return "0";
		}
		
	}	

	public function getAbsentDays($id, $date){
		$attendance = Attendance::model()->findAllByAttributes(array('staff_id'=>$id), 'FROM_UNIXTIME(login, "%m") = "'.date('m', $date).'" AND FROM_UNIXTIME(login, "%Y") = "'.date('Y', $date).'"');
		$holiday = 0;
		$year = date('Y', $date);
		$month = date('m', $date);
		for ($i=1; $i <= date('t') ; $i++) {			
			$new = $year . "-" . $month . "-" . $i;
			if(date('D', strtotime($new)) == 'Sat'){
				$holiday +=1;
			}
		}
		$late = count(Attendance::model()->findAllByAttributes(array('staff_id'=>$id, 'login_status'=>'late'), 'FROM_UNIXTIME(login, "%m") = "'.date('m', $date).'" AND FROM_UNIXTIME(login, "%Y") = "'.date('Y', $date).'"'));
		$late = floor($late/3);
		$absent = date('t', $date) - count($attendance) - $holiday - $late;				
		$salary = Staff::model()->with('designation')->findByPk($id);
		$salary = $salary->getRelated('designation')->salary;
		$salary = $absent * $salary/(date('t', $date) - $holiday);
		return round($salary, 2);
	}

	public function getTdsRate($id, $amount){
		$staff = Staff::model()->with('designation')->findByPk($id);
		$status = $staff->marital_status;
		$yearly = $amount*12;
		$tdsAmount = 0;		
		$tds = TdsRate::model()->findAllByAttributes(array('marital_status'=>$status), array('order'=>'upto_amount ASC'));
		foreach($tds as $a){
			if($yearly >=$a->upto_amount && $yearly > 0){
				$yearly = $yearly - $a->upto_amount;
				$tdsAmount += $a->upto_amount * $a->tds_rate/100;
			}elseif($yearly <= $a->upto_amount && $yearly > 0){
				$tdsAmount +=  $yearly * $a->tds_rate/100;
				$yearly = $yearly - $a->upto_amount;
			}

		}
		//$tds = TdsRate::model()->findByAttributes(array('marital_status'=>$status), 'upto_amount >=  "' . $amount*12 . '"');
		if(!empty($tdsAmount)){
			return round($tdsAmount/12, 2);
		}else{
			return '0';
		}
	}

	public function getFullName() {
    		return $this->fname . ' ' . $this->lname;
	}	
}
