<?php
/* @var $this TdsRateController */
/* @var $model TdsRate */

$this->breadcrumbs=array(
	'Tds Rates'=>array('index'),
	'Create',
);
$this->menu=array(
	array('label'=>'<i class="icon-list"></i>Manage TDS Rates', 'url'=>array('admin')),
                array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-plus"></i> Add new TDS rate</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Settings' => array('/Site/Settings'),
    	'Manage' => array('admin'),
    	'Create'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>