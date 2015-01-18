<div id="staff-image">

	<div class="row-fluid">
        <div id="staff-img">
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/user-pics/<?php echo $model->profile_pic; ?>" class="img-circle">
        </div>
        <br>
        
        <div class="span8" id="staff-desc">
            <h3><?php echo $model->fname . " " . $model->lname?></h3>
            <h6>Email: <?php echo $model->email; ?></h6>
            <h6>Department: <?php echo Department::model()->findByPk($model->department_id)->department_name; ?></h6>
            <h6>Designation: Officer</h6>
            <h6>Date Joined: <?php echo date('Y-m-d', $model->join_date); ?></h6>
        </div>
         <div class="span2">
            <div class="btn-group">
                <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
                    Action 
                    <span class="icon-cog icon-white"></span><span class="caret"></span>
                </a>          
                 <ul class="dropdown-menu">
                    <li><a href="<?php echo Yii::app()->createUrl('Staff/edit/'.Yii::app()->session['uid']); ?>"><span class="icon-wrench"></span> Modify</a></li>
                </ul>    
            </div>
        </div>
	</div>
</div>

<?php 
$model->password = '**********';
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type'=>'bordered striped',
	'id' => 'staff-detail-table',
	'attributes'=>array(
		'staff_id',
		'fname',
		'lname',
		'address',
		'contact',
		'username',
		'password',
		//'designation_id',
		array('label'=>'Office Start time', 'value'=> date('h:i a', strtotime($model['officeTime'][0]->start_time))),
		array('label'=>'Office End time', 'value'=> date('h:i a', strtotime($model['officeTime'][0]->end_time))),
	),
)); ?>

<div class="clear-fix"></div>