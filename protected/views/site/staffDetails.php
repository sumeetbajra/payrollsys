<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>Staff Details', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('Site/StaffDetails'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('Site/AttendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-copy"></i>Salary Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>System Settings', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),

    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);
?>

<div class="page-title"><i class="icon-user"></i> &nbsp;Staff Details</div>

<b>All the staffs present</b>



<?php 
$gridDataProvider = new CArrayDataProvider(array(
    array('id'=>1, 'firstName'=>'Mark', 'lastName'=>'Otto', 'Department'=>'Finance'),
    array('id'=>2, 'firstName'=>'Jacob', 'lastName'=>'Thornton', 'Department'=>'Research'),
    array('id'=>3, 'firstName'=>'Stu', 'lastName'=>'Dent', 'Department'=>'Exco'),
));


$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered',
    'dataProvider'=>$gridDataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'S.N'),
        array('name'=>'firstName', 'header'=>'First name'),
        array('name'=>'lastName', 'header'=>'Last name'),
        array('name'=>'Department', 'header'=>'Department'),
    ),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Add new',
    'type'=>'primary',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#myModal',
    ),
)); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Add new Staff</h4>
</div>
 
<div class="modal-body">
    
    
<label>First Name:</label>
<?php echo CHtml::textField('fName', '', array('placeholder'=>'First Name', 'class'=>'span6')); ?>

<label>Last Name: </label>
<?php echo CHtml::textField('fName', '', array('placeholder'=>'Last Name', 'class'=>'span6')); ?>

<label>Department: </label>
<?php echo CHtml::dropDownList('attendance', '', array(''=> '--Select--','1'=>'Finance', '2'=>'ExCO', '3'=>'Research'), array('class'=>'span6'));?>

</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Add',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

