<?php
/* @var $this StaffController */
/* @var $data Staff */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->staff_id), array('view', 'id'=>$data->staff_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fname')); ?>:</b>
	<?php echo CHtml::encode($data->fname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lname')); ?>:</b>
	<?php echo CHtml::encode($data->lname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact')); ?>:</b>
	<?php echo CHtml::encode($data->contact); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('department_id')); ?>:</b>
	<?php echo CHtml::encode($data->department_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('designation_id')); ?>:</b>
	<?php echo CHtml::encode($data->designation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('join_date')); ?>:</b>
	<?php echo CHtml::encode($data->join_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_start_time')); ?>:</b>
	<?php echo CHtml::encode($data->office_start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office_end_time')); ?>:</b>
	<?php echo CHtml::encode($data->office_end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	*/ ?>

</div>