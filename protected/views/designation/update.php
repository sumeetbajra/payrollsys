<?php
/* @var $this DesignationController */
/* @var $model Designation */

$this->breadcrumbs=array(
	'Designations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon-group"></i> Manage Designation', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create Designation', 'url'=>array('create')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<h1>Update Designation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>