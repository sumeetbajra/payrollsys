<?php
/* @var $this DepartmentController */
/* @var $model Department */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'department-form',
	'htmlOptions'=>array('class'=>'well'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<h5>Please fill in the following details.</h5><hr>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'department_name'); ?>
		<?php echo $form->textField($model,'department_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'head_id'); ?>
		<?php 
		$staff = Staff::model()->findAll();
		$staffs = array();
		foreach ($staff as $key => $value) {
			$staffs[$value->staff_id] = $value->fname . " " . $value->lname;
		}
		echo $form->dropDownList($model, 'head_id', $staffs, array('prompt'=>'Select department head'));
		/*$this->widget('bootstrap.widgets.TbTypeahead', array(
			'model'=>$model,
    'attribute'=>'head_id',
    'options'=>array(
        'source'=> $staffs,
        'items'=>4,
        'matcher'=>"js:function(item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
        }",
    ),
)); */?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->