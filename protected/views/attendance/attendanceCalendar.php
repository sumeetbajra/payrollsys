<style>
.e-calendar-view {
width: 100%;
height: 600px;
margin: 40px 40px 10px 0;
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
if(Yii::app()->user->getState('role') == 'exco'){
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    ); 
}else{
    $user = Staff::model()->findByPk(Yii::app()->session['uid']);
    $this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('/Staff/payrollSheet/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report',  'active'=>'true', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    );
}

$staff = Staff::model()->with('officeTime')->findByPk(Yii::app()->session['uid']);
?>

<div class="page-title"><i class="icon-calendar"></i> Attendance Report</i></div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Attendance Report',
))); ?>


<h5>Attendance Report for <?php echo $staff->fname; ?> (Office time: <?php echo date('h:i a', strtotime($staff['officeTime'][0]->start_time)) . ' to ' .  date('h:i a', strtotime($staff['officeTime'][0]->end_time));?>)</h5><br>

<?php $this->widget(
    'bootstrap.widgets.TbButtonGroup',
    array(
        'buttons' => array(
            array('label' => 'Select month', 'icon'=>'icon-time', 'url' => '#', 'type'=>'', 'htmlOptions'=>array('data-target'=>'#myModal', 'data-toggle'=>'modal'),
    ),
            array('label' => 'Today', 'icon'=>'icon-globe', 'url' => '#', 'type'=>'null', 'htmlOptions'=>array('id'=>'display-today')),
        ),
          'htmlOptions'=>array('class'=>'pull-left'),
    ));
$this->widget(
    'bootstrap.widgets.TbButtonGroup',
    array(
        'buttons' => array(
            array('label' => 'Calendar View', 'icon'=>'icon-calendar', 'url' => '#', 'active'=>true),
            array('label' => 'Week View', 'icon'=>'icon-list-alt', 'url' => Yii::app()->createUrl('Staff/attendanceStatistics')),
              
        ),
        'htmlOptions'=>array('class'=>'pull-right'),
    )
);
?>
<br>

<?php 
$this->widget('ecalendarview.ECalendarView', array(
  
  'itemView' => '../attendance/_view',
  //'titleView' => '_title',
  //'cssFile' => 'css/calendar.css',
  'ajaxUpdate' => true,
  'dataProvider' => array(
    'pagination' => array(
      'currentDate' => new DateTime("now"),
      'pageSize' => 'month',
      'pageIndex' => 0,
      'pageIndexVar' => 'MyCalendar_page',
      'isMondayFirst' => false,
    )
  )
)); 

unset(Yii::app()->session['join_date']);
?>

<b>*Please click on the status above for more detail.</b><div style="height:30px"></div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 style="text-transform:none">Select year and month</h4>
</div>
 
<div class="modal-body">
   <?php echo CHtml::dropDownList('smonth', '', $months); ?>&nbsp; <?php echo CHtml::dropDownList('syear', '', $year); ?>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'submit',
        'label'=>'View',
         'id'=>'view-month',
        //'url' => Yii::app()->createUrl('/Staff/forgotPassword'),
        'htmlOptions'=>array('class'=>'btn-primary', 'data-dismiss'=>'modal'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>


<script>
$(document).ready(function(){
  $('.e-calendar-view').on('hover', '.status', function(){
    $(this).popover();
  });

  $('#view-month').on('click', function(){
    var month = $('#smonth').val(),
          year = $('#syear').val();
    if(month != '' && year != ''){
       var date = new Date(),
          year1 = date.getFullYear(),
          month1 = date.getMonth(),
          diff = (((year1 - year) * 12) + (month1 - month) + 1) * -1;
          $.ajax({
        'url': 'attendanceReport?MyCalendar_page='+diff,
        'context': $('.e-calendar-view'),
        'cache': false,
        'success': function(data) {
          var calendarId = '#' + this.attr('id');
          var calendarData = $(calendarId, data);
          this.html(calendarData.html());
        }
      });
    }      
  });

  $('#display-today').on('click', function(){
      $.ajax({
        'url': 'attendanceReport?MyCalendar_page=0',
        'context': $('.e-calendar-view'),
        'cache': false,
        'success': function(data) {
          var calendarId = '#' + this.attr('id');
          var calendarData = $(calendarId, data);
          this.html(calendarData.html());
        }
      });
  });
});
</script>