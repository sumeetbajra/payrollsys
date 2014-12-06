<?php
/* @var $this TdsRateController */
/* @var $model TdsRate */

$this->breadcrumbs=array(
	'Tds Rates'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon-list"></i>List TDS Rates', 'url'=>array('admin')),
	array('label'=>'<i class="icon-plus"></i>Add new rate', 'url'=>array('create')),
                array('label'=>'<i class="icon-chevron-sign-left"></i>Back to Settings', 'url'=>Yii::app()->createUrl('Site/Settings')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tds-rate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="page-title"><i class="icon-tumblr-sign"></i> Manage TDS Rates</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Settings' => array('/Site/Settings'),
    	'Manage TDS Rates'
))); ?>

<h4>TDS Rates</h4><hr>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'tds-rate-grid',
	'dataProvider'=>$model->search(),
	'type' => 'bordered striped',
	'columns'=>array(
		'id',
		'marital_status',
		'upto_amount',
		'tds_rate',
		  array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("TdsRate/".$data->id)',
                    'options' => array(
                        'class' => 'btn btn-small view'
                    )),
                      'update' => array(
                    'label' => 'Update',
                    'url' => 'Yii::app()->controller->createUrl("TdsRate/update/".$data->id)',
                    'options' => array(
                        'class' => 'btn btn-small update',
                    )),
                      'delete' => array(
                    'label' => 'Delete',
                    'url' => 'Yii::app()->controller->createUrl("TdsRate/delete/".$data->id)',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
	),
)); ?>
