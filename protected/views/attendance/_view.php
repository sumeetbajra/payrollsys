<?php
$calendar = Attendance::model()->findByAttributes(array('staff_id'=>Yii::app()->session['uid']), 'FROM_UNIXTIME(login,"%Y-%m-%d") = "'.$data->date->format("Y-m-d") . '"');
$staff = Staff::model()->findByPk(Yii::app()->session['uid']);
$status = '<font color="red">Absent</font>';
$time = 'Absent';
	if(!empty($calendar)){
		if($calendar['login_status'] == 'On time'){
			$status = '<font style="color:rgb(0, 209, 0);">Present</font>';
			Yii::app()->session['join_date'] = $staff->join_date;
			$time = 'Login time: ' . date('h:i a', $calendar->login) . '<br>Logout time: ' . (!empty($calendar->logout) ? date('h:i a', $calendar->logout) : 'N/A' );
		}elseif($calendar['login_status'] == 'Late'){
			$status = '<font style="color:rgb(188, 188, 188)">Late</font>';\
			Yii::app()->session['join_date'] = $staff->join_date;
			$time = 'Login time: ' . date('h:i a', $calendar->login) . '<br>Logout time: ' . (!empty($calendar->logout) ? date('h:i a', $calendar->logout) : 'N/A' );
		}
	}
?>
<span style="font-size: 16px;">
<?php 
if($data->date->format('D') == 'Sat'){  
	echo "<font color='red'>" . $data->date->format('d') . "</font>"; 
}else{
echo $data->date->format('d'); 
}
?></span> <br/>  
<?php if($data->date->format('y-m-d') < date('y-m-d', Yii::app()->session['join_date']) || $data->date->format('y-m-d') > date('y-m-d', time())){ ?>
		<span style="font-size: 13px; opacity:0"  class="status" ><?php echo $status; ?></span> <br/>
<?php }else{ ?>
	<?php if($data->date->format('D') != 'Sat'){ ?>
		<span style="font-size: 13px; cursor:pointer"  class="status" data-title = 'Attendance detail' data-placement = 'top' data-content = "<?php echo $time; ?>"  data-toggle = 'popover' data-html="true"><?php echo $status; ?></span> <br/>
	<?php } ?>
<?php } ?>


  
  
