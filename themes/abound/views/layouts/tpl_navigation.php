<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="#">Payroll and Attendance System</a>
          
          <div class="nav-collapse">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array(
                           array('label'=>'Dashboard', 'url'=>Yii::app()->createUrl('/Site/Index'), 'icon'=>'icon-th'),
                array('label'=>'Staff Management', 'url'=>'#', 'icon'=>'icon-user', 'items'=>array(
                    array('label'=>'Add Staff', 'url'=>Yii::app()->createUrl('/Staff/create'), 'icon'=>'icon-plus'),
                    array('label'=>'View All Staff', 'url'=>Yii::app()->createUrl('/Staff/admin'), 'icon'=>'icon-th-list'),
                )),
                   array('label'=>'Attendance', 'url'=>Yii::app()->createUrl('Staff/attendanceReport'), 'icon'=>'icon-calendar'),
                array('label'=>'Reports', 'url'=>'#', 'icon'=>'icon-paper-clip', 'items'=>array(
                    array('label'=>'Attendance Report', 'url'=>Yii::app()->createUrl('/Attendance/departAttendanceReport'), 'icon'=>'icon-file-alt'),
                    array('label'=>'Salary Sheet', 'url'=>Yii::app()->createUrl('/Staff/salarySheet'), 'icon'=>'icon-file-alt'),

                    )),
                  array('label'=>'Settings', 'url'=>Yii::app()->createUrl('Site/Settings'), 'icon'=>'icon-gear'),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                )); ?>
    	</div>
    </div>
	</div>
</div>
