<?php

/**
 * This is the model class for table "designation".
 *
 * The followings are the available columns in table 'designation':
 * @property integer $id
 * @property string $designation
 * @property integer $grade
 * @property integer $salary
 */
class Designation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'designation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('designation, grade, salary', 'required'),
			array('grade, salary', 'numerical', 'integerOnly'=>true, 'min'=>0),
			array('designation', 'length', 'max'=>100),
			array('designation', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Designation can only contain alphabet characters'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, designation, grade, salary', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'designation' => 'Designation',
			'grade' => 'Grade',
			'salary' => 'Salary',
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
		$criteria->compare('designation',$this->designation,true);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('salary',$this->salary);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Designation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
