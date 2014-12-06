<?php
/* @var $this AllowancesController */
/* @var $model Allowances */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'allowanceId'); ?>
		<?php echo $form->textField($model,'allowanceId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allowanceName'); ?>
		<?php echo $form->textField($model,'allowanceName',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->