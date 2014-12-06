<?php
/* @var $this TdsRateController */
/* @var $data TdsRate */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('marital_status')); ?>:</b>
	<?php echo CHtml::encode($data->marital_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upto_amount')); ?>:</b>
	<?php echo CHtml::encode($data->upto_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tds_rate')); ?>:</b>
	<?php echo CHtml::encode($data->tds_rate); ?>
	<br />


</div>