<?php
/* @var $this TdsRateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tds Rates',
);

$this->menu=array(
	array('label'=>'Create TdsRate', 'url'=>array('create')),
	array('label'=>'Manage TdsRate', 'url'=>array('admin')),
);
?>

<h1>Tds Rates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
