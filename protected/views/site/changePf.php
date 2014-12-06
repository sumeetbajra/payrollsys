<?php $this->menu=array(
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gear"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/settings'), 'linkOptions'=>array()),
    ); 
?>

<div class="page-title"><i class="icon-inr"></i> Change Provident Fund Rates</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Settings' => array('/Site/settings'),
    	'Provident Fund Rates'
))); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pf-form',
	'htmlOptions'=>array('class'=>'well'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>
<h5>Please fill in the following details.</h5><hr>

	<?php echo $form->errorSummary($pf); ?>
	<?php echo $form->errorSummary($pfc); ?>

	<div class="row">
		<?php echo $form->labelEx($pf,'pf_percent'); ?>
		<?php echo $form->textField($pf,'pf_percent',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($pfc,'rate'); ?>
		<?php echo $form->textField($pfc,'rate',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
