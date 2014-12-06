<?php
/* @var $this TdsRateController */
/* @var $model TdsRate */

$this->breadcrumbs=array(
	'Tds Rates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon-inr"></i> Manage TDS rates', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create new TDS rate', 'url'=>array('create')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-edit"></i>Update TDS rate</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Settings' => array('/Site/settings'),
    	'Manage TDS rates' => array('admin'),
    	'Update'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>