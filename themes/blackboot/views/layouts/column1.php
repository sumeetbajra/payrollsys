<?php $this->beginContent('//layouts/main'); ?>

<?php
$login_id = Yii::app()->user->getState('login_id');
if(empty($login_id)){
    $logout =    array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Logout', 'url'=>Yii::app()->createUrl('Site/logout')),    
            ));
}else{
    $logout = array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right', 'data-toggle'=>'modal',
        'data-target'=>'#myModal'),
            'items'=>array(
                array('label'=>'Logout', 'url'=>'#'),              
            ));
}
?>

<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'null', // null or 'inverse'
    'brand'=>'Payroll and Attendance System',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Dashboard', 'url'=>Yii::app()->createUrl('/Site/Index'), 'icon'=>'icon-th'),
                array('label'=>'Staff Management', 'url'=>'#', 'icon'=>'icon-user', 'items'=>array(
                    array('label'=>'Add Staff', 'url'=>Yii::app()->createUrl('/Staff/create'), 'icon'=>'icon-plus'),
                    array('label'=>'View All Staff', 'url'=>Yii::app()->createUrl('/Staff/admin'), 'icon'=>'icon-th-list'),
                )),
                array('label'=>'Attendance', 'url'=>Yii::app()->createUrl('Staff/attendanceReport'), 'icon'=>'icon-calendar'),
                array('label'=>'Reports', 'url'=>'#', 'icon'=>'icon-paper-clip', 'items'=>array(
                    array('label'=>'Attendance Report', 'url'=>Yii::app()->createUrl('/Attendance/departAttendanceReport'), 'icon'=>'icon-calendar'),
                    array('label'=>'My Payroll Sheet', 'url'=>Yii::app()->createUrl('/Staff/payrollSheet/'.Yii::app()->session['uid']), 'icon'=>'icon-user'),
                    array('label'=>'Salary Sheet', 'url'=>Yii::app()->createUrl('/Staff/salarySheet/'), 'icon'=>'icon-file'),
                    array('label'=>'Staff Payroll Sheet', 'url'=>Yii::app()->createUrl('/Staff/staffPayroll/'), 'icon'=>'icon-group'),
                	)),
                  array('label'=>'Settings', 'url'=>Yii::app()->createUrl('Site/Settings'), 'icon'=>'icon-gear'),
            ),
        ),
      $logout,
    ),
)); ?>
<div class="row-fluid">
	<div class="span12">
		<div class="main">
			<?php echo $content; ?>                
		</div>	
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Are you sure?</h4>
</div>
 
<div class="modal-body">
    <p>Logging out of the system will record your logout time for today as well.<br>
        Logout time to be recorded: <?php echo  date('h:i a', time()); ?><br>
        Logout status: 
        <?php 
        $logout = StaffOfficeTime::model()->findAllByAttributes(array('staff_id'=>Yii::app()->session['uid']), array('order'=>'effective_date DESC'));
        if(isset($logout[0])){
            $logout = $logout[0]->end_time;
        }else{
            $logout = 0;
        }
        if(date('H:i:s', time()) < $logout){
            echo "Early";
        }else{
            echo "On time";
        }
        ?>
    </p>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Confirm',
        'url'=>Yii::app()->createUrl('/Site/logout'),
        'htmlOptions'=>array(),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancel',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

