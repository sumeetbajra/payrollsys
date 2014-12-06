<?php
/* @var $this TdsRateController */
/* @var $model TdsRate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tds-rate-form',
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
		<?php echo $form->labelEx($model,'marital_status'); ?>
		<?php echo $form->dropDownList($model, 'marital_status', array(''=>'--Marital status--', 'Single'=>'Single', 'Married'=>'Married', 'Divorced'=>'Divorced')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'upto_amount'); ?>
		<?php echo $form->textField($model,'upto_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tds_rate'); ?>
		<?php echo $form->textField($model,'tds_rate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->