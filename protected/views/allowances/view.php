<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('index'),
	$model->allowanceId,
);

$this->menu=array(
	array('label'=>'<i class="icon-money"></i> Manage Allowances', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create Allowance', 'url'=>array('create')),
	array('label'=>'<i class="icon-edit"></i> Update Allowance', 'url'=>array('update', 'id'=>$model->allowanceId)),
	array('label'=>'<i class="icon-trash"></i> Delete Allowance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->allowanceId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-money"></i> Allowance Details</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage allowances' => array('/Allowances/admin'),
    	'View Allowance'
))); ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'allowanceId',
		'allowanceName',
	),
)); ?>
