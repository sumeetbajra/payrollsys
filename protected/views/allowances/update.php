<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('index'),
	$model->allowanceId=>array('view','id'=>$model->allowanceId),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon-money"></i> Manage Allowances', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i> Create Allowance', 'url'=>array('create')),
	array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-edit"></i> Update Allowance</div>
<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage departments' => array('/Allowances/admin'),
    	'Update'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>