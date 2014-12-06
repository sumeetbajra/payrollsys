<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon-money"></i>Manage Allowances', 'url'=>array('admin')),
                array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-plus"></i> Create Allowance</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage allowances' => array('/Allowances/admin'),
    	'Create'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>