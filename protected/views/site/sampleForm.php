<style>
.labelEx{
    width: 124px;
display: inline-block;
text-align: right;
padding-right: 18px;
font-weight: bold;
}

form{
    line-height: 50px;
}

.span3{

}
</style>

<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>Staff Details', 'url'=>Yii::app()->controller->createUrl('Site/StaffDetails'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-copy"></i>Salary Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>System Settings', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),

    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);
?>

<div class="page-title"><i class="icon-calendar"></i>  &nbsp;Attendance Report</div>

    <?php 
    $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title'=>'Add New Attendance Record',
    'headerIcon'=>'icon-plus',
    ));


    ?>
<?php
    $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'action'=>''
        ));
    ?>



    
    
<span class="labelEx">Staff Name:</span>
<?php $this->widget('bootstrap.widgets.TbTypeahead', array(
    'name'=>'typeahead',
    'options'=>array(
        'source'=>array('Anil Sharma', 'Abishan Dahan', 'Bishnu Gupta', 'Christina Shakya', 'Cherry Austin', 'Serena Williams', 'Sumit Bajracharya', 'Kelina Adhikari', 'Manisha Bajracharya'),
        'items'=>4,
        'matcher'=>"js:function(item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
        }",
    ),
     'htmlOptions'=>array('class'=>'span7', 'placeholder'=>'Staff Name'),
)); ?>
<br>
<span class="labelEx">Date: </span>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'name'=>'delivery_date',

                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'drop',
                        'dateFormat'=>'yy-mm-dd',
                        'changeYear'=>true,
                        'changeMonth'=>true,
                        'yearRange'=>'1900:',
                    ),
                    'htmlOptions'=>array(
                        'value'=>date('y-m-d', time()),
                        'style'=>'height:20px;','placeholder'=>'Date of Attendance', 'class'=>'span7'
                    ),
                ));
?>
<br>
<span class="labelEx">Attendance: </span>
<?php echo CHtml::dropDownList('attendance', '', array(''=> '--Select--','1'=>'Absent', '2'=>'Present', '3'=>'Late'), array('class'=>'span7'));?>
<br>

<span class="labelEx">Contact: </span>
<?php echo CHtml::textField('something', '', array('class'=>'span7', 'placeholder'=>'Contact'));?>
<br>

<span class="labelEx">Address: </span>
<?php echo CHtml::textField('something', '', array('class'=>'span7', 'placeholder'=>'Address'));?>
<br>

<span class="labelEx">Mother's Name: </span>
<?php echo CHtml::textField('something', '', array('class'=>'span7', 'placeholder'=>'Mother\'s Name'));?>
<br>

<span class="labelEx">Father's Name: </span>
<?php echo CHtml::textField('something', '', array('class'=>'span7', 'placeholder'=>'Father\'s Name'));?>
<br>

<span class="labelEx">
    </span>
   <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'id' => 'sbutton','type'=>'primary', 'label'=>'Proceed')); ?>
   
   
           <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-input-small'))); ?></td><td></td>



    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
    <!-- <div style="display:none">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Primary',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
)); ?></div> -->