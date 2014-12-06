<?php
/* @var $this DesignationController */
/* @var $model Designation */

$this->breadcrumbs=array(
	'Designations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon-group"></i> Manage Designation', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create Designation', 'url'=>array('create')),
	array('label'=>'<i class="icon-edit"></i> Update Department', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon-trash"></i> Delete Department', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-group"></i> Designation Details</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'designation',
		'grade',
		'salary',
	),
)); ?>
