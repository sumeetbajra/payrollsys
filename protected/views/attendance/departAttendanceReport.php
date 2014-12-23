<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-search"></i>Custom search', 'url'=>Yii::app()->controller->createUrl('/Attendance/customAttendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-download-alt"></i>Download as pdf', 'url'=>Yii::app()->controller->createUrl('/Staff/departWeeklyAttendance/'), 'linkOptions'=>array('target'=>'_new')),
    ); 

$staff = Staff::model()->findByPk(Yii::app()->session['uid']);

?>

<div class="page-title"><i class="icon-calendar"></i> Department Attendance Report</i></div>

<h4>Department wise attendance report for this week</h4><hr>

<h5>Please choose department:</h5>

<?php echo CHtml::dropDownList('depart', '', $departs, array('prompt'=>'Department', 'class'=>'span5')); ?>

<?php 

$model = new Attendance;
/*echo "<pre>";
print_r($model->departSearch());
exit;*/

$this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Proceed',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'null', // null, 'large', 'small' or 'mini'
   'htmlOptions'=>array('id'=>'proceed', 'style'=>'position:relative; top:-6px'),
)); ?>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendancee-grid',
    'dataProvider'=>$model->departSearch($departId),
    'type'=>'striped bordered',
    'template'=>'{summary}{pager}{items}{pager}',
    'columns'=>array(
    	'id: Staff Id',
    	'fname: First Name',
    	'lname: Last Name',
    	'designation: Designation',
    	'lates: Late Attendance',
    	'earlies: Early Leaves',
          array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}',
            'buttons' => array(
                      'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("Staff/attendanceDetail/".$data["id"])',
                    'options' => array(
                        'class' => 'btn btn-small view',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
       
      ),
      
    ));

?>

<script>
$(document).ready(function(){
	$('#proceed').on('click', function(){
		var depart = $('select[name="depart"]').val();
		$.fn.yiiGridView.update('attendancee-grid', {
          			data: 'depart='+depart
        		});       
	});

});
</script>