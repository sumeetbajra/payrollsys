<style>
.e-calendar-view {
width: 100%;
height: 600px;
margin: 40px 40px 40px 0;
}

td.not-relevant .status{
display:none;
}

.e-calendar-view tr td{
	border: solid thin #ECECEC;
}

.e-calendar-view tr td.current{
	background: #F1F1F1;
}
</style>

<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    ); 
$staff = Staff::model()->findByPk($id);

?>

<div class="page-title"><i class="icon-calendar"></i> Attendance Report</i></div>

<h5 style="float:left">Attendance Report for <?php echo $staff->fname; ?> (Office time: <?php echo date('h:i a', strtotime($staff['officeTime'][0]->start_time)) . ' to ' .  date('h:i a', strtotime($staff['officeTime'][0]->end_time));?>)</h5><br>

<?php $this->widget(
    'bootstrap.widgets.TbButtonGroup',
    array(
        'buttons' => array(
            array('label' => 'Calendar View', 'icon'=>'icon-calendar', 'url' => Yii::app()->createUrl('Staff/attendanceReport')),
            array('label' => 'Week View', 'icon'=>'icon-list-alt', 'url' => '#', 'active'=>true),
        ),
        'htmlOptions'=>array('class'=>'pull-right'),
    )
);
?>
<div class="clear"></div>

<?php 
$model = new Attendance;
$model->staff_id = $id;
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendance-grid',
    'dataProvider'=>$model->thisWeekSearch(),
    'type'=>'striped bordered',
    'template'=>'{pager}{items}{pager}{summary}',
    'columns'=>array(
        array(
            'header'=>'S.N',
            'value'=>'$row+1',
            ),
        array(
            'header'=>'Date',
            'value'=>'date("d M, Y", $data->login)'
            ), 
        array(
            'header'=>'Login Time',
            'value'=>'date("h:i a", $data->login)'
            ),
          array(
            'header'=>'Login Status',
            'value'=>'$data->login_status',
            ),
     
        array(
            'header'=>'Logout Time',
            'value'=>'(empty($data->logout) ? "N/A" : date("h:i a", $data->logout))'
            ),
         array(
            'header'=>'Logout Status',
            'value'=>'(empty($data->logout) ? "N/A" : $data->logout_status )'
            ),
      
      ),
    ));

?>

<br>

