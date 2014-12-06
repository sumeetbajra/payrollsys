<?php $this->beginContent('//layouts/main'); ?>
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
                                array('label'=>'Attendance Report', 'url'=>Yii::app()->createUrl('/Attendance/departAttendanceReport'), 'icon'=>'icon-file-alt'),
               		array('label'=>'Salary Sheet', 'url'=>Yii::app()->createUrl('/Staff/salarySheet'), 'icon'=>'icon-file-alt'),

                	)),
                  array('label'=>'Settings', 'url'=>Yii::app()->createUrl('Site/Settings'), 'icon'=>'icon-gear'),
            ),
        ),
      
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Logout', 'url'=>Yii::app()->createUrl('Site/logout')),
              
            ),
        ),
    ),
)); ?>
      <div class="row-fluid">
        <div class="span3">
         <?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'encodeLabel'=>false,
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'sidebar'),
				'submenuHtmlOptions' => array(
                    'class' => 'dropdown-menu',
                )
			));
			$this->endWidget();
		?>
	</div><!-- sidebar span3 -->

	<div class="span9">
		<div class="main">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>



