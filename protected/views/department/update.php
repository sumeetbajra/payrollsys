<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Departments'=>array('index'),
	$model->department_id=>array('view','id'=>$model->department_id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon-building"></i> Manage Department', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create Department', 'url'=>array('create')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-edit"></i> Update Department</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage departments' => array('/Department/admin'),
    	'Update'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>