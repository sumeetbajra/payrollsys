<?php

/**
 * This is the model class for table "attendance".
 *
 * The followings are the available columns in table 'attendance':
 * @property integer $id
 * @property integer $staff_id
 * @property integer $login
 * @property integer $logout
 * @property string $login_status
 * @property string $logout_status
 */
class Attendance extends CActiveRecord
{
	public $depart;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'attendance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_id, login, login_status', 'required'),
			array('staff_id, login, logout', 'numerical', 'integerOnly'=>true),
			array('login_status, logout_status', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staff_id, login, logout, login_status, logout_status', 'safe', 'on'=>'search'),
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
			'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staff_id' => 'Staff',
			'login' => 'Login',
			'logout' => 'Logout',
			'login_status' => 'Login Status',
			'logout_status' => 'Logout Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('staff_id',$this->staff_id);
		$criteria->compare('login',$this->login);
		$criteria->compare('logout',$this->logout);
		$criteria->compare('login_status',$this->login_status,true);
		$criteria->compare('logout_status',$this->logout_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	 /* @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function thisWeekSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$sunday = strtotime('last sunday', strtotime('tomorrow'));
		$friday = strtotime('next saturday', strtotime('yesterday'));
		$criteria->compare('id',$this->id);
		$criteria->compare('staff_id', $this->staff_id);
		$criteria->addCondition('login >= "'. $sunday .'"');
		$criteria->addCondition('login <= "'. $friday .'"');
		$criteria->compare('login_status',$this->login_status,true);
		$criteria->compare('logout_status',$this->logout_status,true);

		return  new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function departSearch($id){		
		$result = array();
		$staff = Staff::model()->with('depart')->findAllByAttributes(array('department_id'=>$id));
		foreach ($staff as $key => $value) {
			$result[$key]['id'] = $value->staff_id;
			$result[$key]['fname'] = $value->fname;
			$result[$key]['lname'] = $value->lname;
			$result[$key]['designation'] = Designation::model()->findByPk($value->designation_id)->designation;
			$result[$key]['lates'] = $this->getLates($value->staff_id);
			$result[$key]['earlies'] = $this->getEarlies($value->staff_id);
		}

		$dataProvider=new CArrayDataProvider($result, array(
		'keyField'=>false,
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
		return $dataProvider;
	}

	public function getLates($staff_id){
		$sunday = strtotime('last sunday', strtotime('tomorrow'));
		$friday = strtotime('next saturday', strtotime('yesterday'));
		$sql = 'SELECT count(*) as count, login FROM attendance WHERE login >= ' . $sunday . ' AND login <= '. $friday . ' GROUP BY staff_id, login_status HAVING login_status = "late" AND staff_id = "' . $staff_id . '"';
		$a = Yii::app()->db->createCommand($sql)->queryAll();
		if($a){
			return $a[0]['count'];
		}else{
			return '0';
		}
	}

	public function getEarlies($staff_id){
		$sunday = strtotime('last sunday', strtotime('tomorrow'));
		$friday = strtotime('next saturday', strtotime('yesterday'));
		$sql = 'SELECT count(*) as count, login FROM attendance WHERE login >= ' . $sunday . ' AND login <= '. $friday . ' GROUP BY staff_id, logout_status HAVING logout_status = "early" AND staff_id = "' . $staff_id . '"';
		$a = Yii::app()->db->createCommand($sql)->queryAll();
		if($a){
			return $a[0]['count'];
		}else{
			return '0';
		}
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attendance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
