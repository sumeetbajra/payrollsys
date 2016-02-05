<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-download-alt"></i>Download as pdf', 'url'=>Yii::app()->controller->createUrl('/Staff/departWeeklyAttendance/'), 'linkOptions'=>array('target'=>'_new')),
    ); 

$staff = Staff::model()->findByPk(Yii::app()->session['uid']);

?>

<div class="page-title"><i class="icon-dollar"></i> Staff Salary Report</i></div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Staff Payroll'
))); ?>

<h4>Staff salary report for this month</h4><hr>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendancee-grid',
    'dataProvider'=>$model->search(),
    'type'=>'striped bordered',
    'filter'=>$model,
    'template'=>'{summary}{pager}{items}{pager}',
    'columns'=>array(
    	array('header'=>'S.N', 'value'=>'$row+1'),
    	'fname: First Name',
    	'lname: Last Name',
    	array('header'=>'Department', 'value'=>'Department::model()->findByPk($data["department_id"])->department_name'),
          array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}',
            'buttons' => array(
                      'view' => array(
                    'label' => 'View',
                    'url' => 'Yii::app()->controller->createUrl("Staff/payrollSheet/".$data["staff_id"])',
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