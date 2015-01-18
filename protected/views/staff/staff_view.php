<?php
/* @var $this StaffController */
/* @var $model Staff */

/*$this->breadcrumbs=array(
	'Staff'=>array('index'),
	$model->staff_id,
);*/

if(Yii::app()->user->getState('role') == 'superadmin'){
    $this->menu=array(
        array('label'=>'<i class="icon-user"></i> Manage Staff', 'url'=>array('admin')),
        array('label'=>'<i class="icon-plus"></i> Create Staff', 'url'=>array('create')),
        array('label'=>'<i class="icon-edit"></i> Update Staff', 'url'=>array('update', 'id'=>$model->staff_id)),
        array('label'=>'<i class="icon-trash"></i> Delete Staff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->staff_id),'confirm'=>'Are you sure you want to delete this item?')),
        array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
    );
}else{
    $user = Staff::model()->findByPk(Yii::app()->session['uid']);
    $this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('/Staff/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('/Staff/payrollSheet/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    );
}
?>

<div class="page-title"><i class="icon-th-list"></i> Complete Staff Detail</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Manage Staff' => array('/Staff/admin'),
        'View Staff'
))); ?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Basic Info', 'url'=>'#', 'active'=>true, 'icon'=>'icon-user'),
        array('label'=>'Allowances', 'url'=>Yii::app()->createUrl('Staff/viewAllowance/'.$id), 'icon'=>'icon-money'),
    ),
)); ?>

<?php $this->renderPartial('view', array('model'=>$model)); ?>
