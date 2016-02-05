<style>
.table tr td{
    border-top: none;
}

.table label{
    font-weight: bold;
}

label[for="Staff_selfPf"]{
    display: none;
}
</style>

<?php

$this->breadcrumbs=array(
	'Staff'=>array('index'),
	'Manage',
);

?>

<?php if(Yii::app()->user->getState('role') == 'superadmin'){
$this->menu=array(
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    ); 

}else{
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.Yii::app()->session['uid']), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.Yii::app()->session['uid']), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    /*array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Site/AttendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-copy"></i>Salary Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>System Settings', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
*/
    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);
}
?>


<div class="page-title"><i class="icon-pencil"></i> Edit your details</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Setting' => array('/Site/settings'),
        'Edit profile',
))); ?>

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'action'=>'',
        'method'=>'POST',
        'id'=>'edit-user-form',
        'htmlOptions'=>array('enctype' => 'multipart/form-data', 'class'=>'well'),
        ));
    ?>
    <?php echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); ?>

    <table class="table">
<tr>
    <td><?php echo $form->labelEx($model, 'fname', array('class'=>'')) ?></td>
    <td style="width:760px"><?php echo $form->textField($model, 'fname', array('class'=>'span7')) ?></td>
</tr>

<tr>
    <td><?php echo $form->labelEx($model, 'lname', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'lname', array('class'=>'span7')) ?></td>
</tr>    

<tr>
    <td><?php echo $form->labelEx($model, 'address', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'address', array('class'=>'span7')) ?></td>
</tr>

<tr>
    <td><?php echo $form->labelEx($model, 'contact', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'contact', array('class'=>'span7')) ?></td>
</tr>
<tr>
    <td><?php echo $form->labelEx($model, 'email', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'email', array('class'=>'span7')) ?></td>
</tr>
<tr>
     <td><?php echo $form->labelEx($model, 'marital_status', array('class'=>'')) ?></td>
    <td><?php echo $form->dropDownList($model, 'marital_status', array(''=>'--Marital Status', 'Single'=>'Single', 'Married'=>'Married', 'Divorced'=>'Divorced'), array('class'=>'span7')); ?></td>
</tr>
<tr>
    <td><?php echo $form->labelEx($model, 'profile_pic', array('class'=>'')) ?></td>
    <td><?php echo $form->fileField($model, 'profile_pic', array('class'=>'span7')) ?></td>
</tr>

<tr>
    <td><b>Staff Self pf</b></td>
    <?php
    $selfpf = StaffSelfPf::model()->findAllByAttributes(array('staff_id'=>$model->staff_id), array('order'=>'effective_date DESC'));
    if(empty($selfpf)){
        $selfpf = 0;
    }else{
        $selfpf = $selfpf[0]->amount;
    }
    ?>
    <td><?php echo $form->textFieldRow($model, 'selfPf', array('class'=>'span7', 'prepend'=>'Rs.', 'value'=>$selfpf)) ?></td>
</tr>
<tr>
    <td><?php echo $form->labelEx($model, 'uuid', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'uuid', array('class'=>'span7', 'placeholder'=>'Device UUID')) ?></td>
</tr>   
</table>
   <?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'id' => 'sbutton','type'=>'primary', 'label'=>'Update')); ?>
   
   
           <?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-input-small'))); ?></td><td></td>



    <?php $this->endWidget(); ?>
    