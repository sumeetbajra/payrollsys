<?php
/* @var $this AllowancesController */
/* @var $data Allowances */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowanceId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->allowanceId), array('view', 'id'=>$data->allowanceId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowanceName')); ?>:</b>
	<?php echo CHtml::encode($data->allowanceName); ?>
	<br />


</div>