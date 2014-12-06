<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus"></i>Create Allowance', 'url'=>array('create')),
                array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('Site/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#allowances-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="page-title"><i class="icon-money"></i> Manage Allowances</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage allowances'
))); ?>

<h4>All the available allowances</h4><hr>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'allowances-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered',
	'filter'=>$model,
	'columns'=>array(
		array('header'=>'S.N', 'value'=>'$row+1'),
		'allowanceName',
		 array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("Allowances/".$data->allowanceId)',
                    'options' => array(
                        'class' => 'btn btn-small view'
                    )),
                      'update' => array(
                    'label' => 'Update',
                    'url' => 'Yii::app()->controller->createUrl("Allowances/update/".$data->allowanceId)',
                    'options' => array(
                        'class' => 'btn btn-small update',
                    )),
                      'delete' => array(
                    'label' => 'Delete',
                    'url' => 'Yii::app()->controller->createUrl("Allowances/delete/".$data->allowanceId)',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
	),
)); ?>
