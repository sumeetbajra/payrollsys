<?php

/**
 * This is the model class for table "staff_allowance".
 *
 * The followings are the available columns in table 'staff_allowance':
 * @property integer $id
 * @property integer $staff_id
 * @property integer $allowance_id
 * @property integer $percentage
 * @property string $effective_date
 */
class StaffAllowance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'staff_allowance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_id, allowance_id, percentage, effective_date', 'required'),
			array('staff_id, allowance_id, percentage', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staff_id, allowance_id, percentage, effective_date', 'safe', 'on'=>'search'),
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
			'allowance'=>array(self::BELONGS_TO, 'Allowances', 'allowance_id'),
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
			'allowance_id' => 'Allowance',
			'percentage' => 'Percentage',
			'effective_date' => 'Effective Date',
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
		$criteria->compare('allowance_id',$this->allowance_id);
		$criteria->compare('percentage',$this->percentage);
		$criteria->compare('effective_date',$this->effective_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffAllowance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * return all the allowances and percentages for a staff
	 * @param  [int] $id [id of the staff]
	 * @return [object]     [allowances and the percentage]
	 */
	public function getStaffAllowances($id){
		$sql = "SELECT * FROM (SELECT * FROM staff_allowance WHERE staff_id = '" . $id . "' ORDER BY id DESC) a JOIN allowances b ON a.allowance_id = b.allowanceId GROUP BY allowance_id";
		$allowances = Yii::app()->db->createCommand($sql)->queryAll();
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($allowances as $key => $value) {
			if($value['percentage'] == 0) {
				unset($result[$key]);
			}
		}
		$dataProvider=new CArrayDataProvider($result, array(
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
		return $dataProvider;
	}

	/**
	 * get allowance list which staff is not allocated to 
	 * @param  [int] $id [id of the staff]
	 * @return [array]     [list of allowances staff is not allocated to]
	 */
	public static function getRemStaffAllowances($id){
		 $sql = "SELECT * FROM allowances WHERE allowanceName NOT IN (SELECT a.allowanceName FROM staff_allowance sa JOIN allowances a ON sa.allowance_id = a.allowanceId GROUP BY sa.allowance_id, sa.staff_id HAVING sa.staff_id = '".$id."' )";
		 $result = Yii::app()->db->createCommand($sql)->queryAll();
		 return $result;
	}

	public function behaviors()
	{
	    return array(
	        // Classname => path to Class
	        'ActiveRecordLogableBehavior'=>
	            'application.behaviors.ActiveRecordLogableBehavior',
	    );
	}
}
