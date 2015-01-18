<style>
.grid-view .filters input{
	
}

#staff-grid_c0{
	width: 60px;
}

table.items td.button-column{
	width: 58px;
}
th a{
	color: white;
}
</style>
<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Staff'=>array('index'),
	'Manage',
);


$this->menu=array(
    array('label'=>'<i class="icon-plus"></i>Create Staff', 'url'=>array('create')),
    array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('Site/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#staff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="page-title"><i class="icon-archive"></i> Manage staffs</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Manage Staff'
))); ?>

<h4>All the registered staff</h4><hr>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'array'=>$array,
	'array1' => $array1,
                'officeTime' => $officeTime
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'staff-grid',
	'type'=>'striped bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template'=>'{summary}{pager}{items}{pager}',
	'columns'=>array(
		'staff_id',
		'fname',
		'lname',
		'address',
		'email',
		/*
		'password',
		'department_id',
		'designation_id',
		'join_date',
		'office_start_time',
		'office_end_time',
		*/
        array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("Staff/".$data->staff_id)',
                    'options' => array(
                        'class' => 'btn btn-small view'
                    )),
                      'update' => array(
                    'label' => 'Update',
                    'url' => 'Yii::app()->controller->createUrl("Staff/update/".$data->staff_id)',
                    'options' => array(
                        'class' => 'btn btn-small update',
                    )),
                      'delete' => array(
                    'label' => 'Delete',
                    'url' => 'Yii::app()->controller->createUrl("Staff/delete/".$data->staff_id)',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
	),
)); ?>


