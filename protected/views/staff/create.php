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
	'Create',
);

$this->menu=array(
    array('label'=>'<i class="icon-user"></i>Manage Staff', 'url'=>array('admin')),
                array('label'=>'<i class="icon-arrow-left"></i>Back', 'url'=>array('admin')),
);

?>


<div class="page-title"><i class="icon-plus"></i> Register new staff</div>


<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Manage Staff' => array('/Staff/admin'),
        'Create'
))); ?>

<?php $this->renderPartial('_form', array('model'=>$model, 'array'=>$array, 'array1'=>$array1, 'officeTime'=>$officeTime)); ?>
