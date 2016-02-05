<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-download-alt"></i>Download as pdf', 'url'=>Yii::app()->controller->createUrl('/Staff/customAttendancePdf/'), 'linkOptions'=>array('target'=>'_new')),
    array('label'=>'<i class="icon-chevron-sign-left"></i>Back', 'url'=>Yii::app()->controller->createUrl('/Staff/departAttendanceReport'), 'linkOptions'=>array()),
    ); 

$staff = Staff::model()->findByPk(Yii::app()->session['uid']);

?>

<div class="page-title"><i class="icon-file-alt"></i> Custom Attendance Report</i></div>

<h4>Attendance report</h4><hr>

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); 

echo CHtml::dropDownList('staff', '', $staffs, array('prompt'=>'--Select Staff--', 'class'=>'span3')); 
echo "&nbsp;";
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'from_date',
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'showAnim' => 'drop',
                            'dateFormat' => 'yy-mm-dd',
                            'changeYear' => true,
                            'changeMonth' => true,
                            'yearRange' => '1900:',
                        ),
                        'htmlOptions' => 
                        array('class' => 'span3', 'placeholder'=>'From date', 'value'=>date('Y-m-d', time())),
                    ));
echo "&nbsp;";
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'to_date',
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'showAnim' => 'drop',
                            'dateFormat' => 'yy-mm-dd',
                            'changeYear' => true,
                            'changeMonth' => true,
                            'yearRange' => '1900:',
                        ),
                        'htmlOptions' => 
                        array('class' => 'span3', 'placeholder'=>'To date', 'value'=>date('Y-m-d', time())),
                    ));
echo "&nbsp;";
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Search', 'htmlOptions'=>array('style'=>'position:relative; top:-6px', 'class'=>'customSearch'))); 
$this->endWidget(); 

$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendance-grid',
    'dataProvider'=>$attendance,
    'type'=>'striped bordered',
    'template'=>'{summary}{items}{pager}',
    'columns'=>array(
        array(
            'header'=>'S.N',
            'value'=>'$row+1',
            ),
        array(
            'header'=>'Date',
            'value'=>'$data["date"]',
            ), 
        array(
            'header'=>'Login Time',
            'value'=>'$data["login_time"]'
            ),
          array(
            'header'=>'Login Status',
            'value'=>'$data["login_status"]',
            ),
     
        array(
            'header'=>'Logout Time',
            'value'=>'(empty($data["logout_time"]) ? "-" : $data["logout_time"])'
            ),
         array(
            'header'=>'Logout Status',
            'value'=>'(empty($data["logout_time"]) ? "-" : $data["logout_status"])'
            ),
           array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{edit}',
            'buttons' => array(
                      'edit' => array(
                    'label' => 'Edit',
                    'url' => 'Yii::app()->controller->createUrl("Staff/attendanceDetail/".$data["id"])',
                    'options' => array(
                        'class' => 'btn btn-small edit',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
      
      ),
    ));

?>
<script>
$(document).ready(function(){
	$('.customSearch').on('click', function(){
		var staff = $('select[name="staff"]').val();
                        var from_date = $('input[name="from_date"]').val();
                        var to_date = $('input[name="to_date"]').val();
		$.fn.yiiGridView.update('attendance-grid', {
          			data: 'staff='+staff+'&from_date='+from_date+'&to_date='+to_date
        		});      
                return false; 
	});

});
</script>