<?php
/* @var $this AllowancesController */
/* @var $model Allowances */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'allowances-form',
	'htmlOptions'=>array('class'=>'well'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<h5>Please fill in the following details.</h5><hr>

	<?php echo $form->errorSummary($model,'Please fix these errors!!!', null,array('class'=>'alert alert-error')); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'allowanceName'); ?>
		<?php echo $form->textField($model,'allowanceName',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->