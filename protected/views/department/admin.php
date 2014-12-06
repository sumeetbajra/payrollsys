<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->breadcrumbs=array(
	'Departments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon-plus"></i>Create Department', 'url'=>array('create')),
                array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('Site/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#department-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="page-title"><i class="icon-building"></i> Manage Departments</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Manage departments'
))); ?>

<h4>All the available departments</h4><hr>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'department-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>'striped bordered',
	'columns'=>array(
		array('header'=>'S.N', 'value'=>'$row+1'),
		'department_name',
		array(
			'header'=>'Department Head',
			'value'=> 'Staff::model()->findByPk($data->head_id)->fname . " " . Staff::model()->findByPk($data->head_id)->lname '
		),
		  array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("Department/".$data->department_id)',
                    'options' => array(
                        'class' => 'btn btn-small view'
                    )),
                      'update' => array(
                    'label' => 'Update',
                    'url' => 'Yii::app()->controller->createUrl("Department/update/".$data->department_id)',
                    'options' => array(
                        'class' => 'btn btn-small update',
                    )),
                      'delete' => array(
                    'label' => 'Delete',
                    'url' => 'Yii::app()->controller->createUrl("Department/delete/".$data->department_id)',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
	),
)); ?>
