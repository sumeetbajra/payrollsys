<?php
/* @var $this TdsRateController */
/* @var $model TdsRate */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'marital_status'); ?>
		<?php echo $form->textField($model,'marital_status',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'upto_amount'); ?>
		<?php echo $form->textField($model,'upto_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tds_rate'); ?>
		<?php echo $form->textField($model,'tds_rate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->