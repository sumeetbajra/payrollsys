<?php
/* @var $this DesignationController */
/* @var $model Designation */

$this->breadcrumbs=array(
	'Designations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus"></i>Create Designation', 'url'=>array('create')),
	array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('/Site/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#designation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="page-title"><i class="icon-group"></i> Manage Designations</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage designations'
))); ?>

<h4>All the available designations</h4><hr>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'designation-grid',
	'dataProvider'=>$model->search(),
	'type' => 'striped bordered',
	'filter'=>$model,
	'columns'=>array(
		array('header'=>'S.N', 'value'=>'$row+1'),
		'designation',
		'grade',
		'salary: Salary (Rs.)',
		  array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("Designation/".$data->id)',
                    'options' => array(
                        'class' => 'btn btn-small view'
                    )),
                      'update' => array(
                    'label' => 'Update',
                    'url' => 'Yii::app()->controller->createUrl("Designation/update/".$data->id)',
                    'options' => array(
                        'class' => 'btn btn-small update',
                    )),
                      'delete' => array(
                    'label' => 'Delete',
                    'url' => 'Yii::app()->controller->createUrl("Designation/delete/".$data->id)',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
	),
)); ?>
