<style>
.table tr td{
    border-top: none;
}

.table label{
    font-weight: bold;
}
</style>
<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Staff'=>array('index'),
	$model->staff_id=>array('view','id'=>$model->staff_id),
	'Update',
);

$this->menu=array(
    array('label'=>'<i class="icon-user"></i> Manage Staff', 'url'=>array('admin')),
    array('label'=>'<i class="icon-plus"></i> Create Staff', 'url'=>array('create')),
    array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);

?>
<div class="page-title"><i class="icon-plus"></i> Update staff details</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Manage Staff' => array('/Staff/admin'),
        'Update'
))); ?>

<div>
<?php $this->renderPartial('_form', array('model'=>$model, 'array'=>$array, 'array1'=>$array1, 'officeTime'=>$officeTime)); ?>
</div>