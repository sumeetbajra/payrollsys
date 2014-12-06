<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Departments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon-building"></i>Manage Department', 'url'=>array('admin')),
                array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-plus"></i> Create Department</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage departments' => array('/Department/admin'),
    	'Create'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>