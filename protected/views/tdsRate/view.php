<?php
/* @var $this TdsRateController */
/* @var $model TdsRate */

$this->breadcrumbs=array(
	'Tds Rates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TdsRate', 'url'=>array('index')),
	array('label'=>'Create TdsRate', 'url'=>array('create')),
	array('label'=>'Update TdsRate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TdsRate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TdsRate', 'url'=>array('admin')),
);
?>

<h1>View TDS #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'marital_status',
		'upto_amount',
		'tds_rate',
	),
)); ?>
