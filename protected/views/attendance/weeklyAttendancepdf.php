<style>
body{
	font-family: Arial;
	font-size: 12px;
}

.logo{
	text-align: center;
}

.title{
	position: relative;
top: -10px;
font-size: 23px;
}

table{
	page-break-inside: avoid;
}

table thead tr th{
	background: #f5f5f5;
}
</style>
<div class="logo">
	<img src="<?php echo Yii::app()->basePath. '/../images/logo.png' ?>"><br><span class="title">Third Pole Connects</span><br> 
	Kamalpokhari, Kathmandu<br>
	Contact: 9841897727, 014357273<br>
	Email: info@thirdpoleconnects.org
</div><br><br>
<?php 
$staff = Staff::model()->findByPk($id);
?>
<span style="font-size:14px;">Weekly Attendance Report</span><br>
Date: 7th December, 2014 to 12th December, 2014<br>
<?php 
$num = 0;
foreach ($attendances  as $key=>$value) {
	if(is_object($value)){
		$num += 1;
	}
}
?>
<?php if($num >= 1) { ?>
Department: <?php echo Department::model()->findByPk($id)->department_name; ?><br><br>
	<?php foreach ($attendances as $staff=>$attendance) { ?>

<?php 
$staff = Staff::model()->findByPk($staff);
?>

Staff Id: <?php echo $staff->staff_id;  ?><br>
Staff Name: <?php echo $staff->fname, " ", $staff->lname; ?><br>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendance-grid',
    'dataProvider'=>$attendance,
    'type'=>'striped bordered',
    'enablePagination'=>false,
    'template'=>'{items}',
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
      ),
    ));
?>
<br>
	
<?php } }else{?>
<br>
Staff Id: <?php echo $staff->staff_id;  ?><br>
Staff Name: <?php echo $staff->fname, " ", $staff->lname; ?><br>
Department: <?php echo Department::model()->findByPk($staff->department_id)->department_name; ?><br>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendance-grid',
    'dataProvider'=>$attendances,
    'type'=>'striped bordered',
    'enablePagination'=>false,
    'template'=>'{items}',
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
      ),
    ));
?>


<?php } ?>