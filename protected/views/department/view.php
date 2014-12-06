<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Departments'=>array('index'),
	$model->department_id,
);

$this->menu=array(
	array('label'=>'<i class="icon-building"></i> Manage Department', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create Department', 'url'=>array('create')),
	array('label'=>'<i class="icon-edit"></i> Update Department', 'url'=>array('update', 'id'=>$model->department_id)),
	array('label'=>'<i class="icon-trash"></i> Delete Department', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->department_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-building"></i> Department Details</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage departments' => array('/Department/admin'),
    	'View Department'
))); ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'department_id',
		'department_name',
		array('name'=>'Department Head', 'value'=>Staff::model()->findByPK($model->head_id)->fname . " " . Staff::model()->findByPK($model->head_id)->lname),
	),
)); ?>
