<style>
.btn-group{
    position: relative;
    right: 35px;
}

.status-panel{
    height: 125px;
    color: white;
    padding-top: 10px;
    border: solid thin #D0D0D0;
    border-radius: 3px;
}

.status-panel h3{
    font-size: 65px;
text-align: center;
}

.status-panel .foot{
position: relative;
background: white;
color: black;
text-align: center;
top: -8px;
padding: 7px 0;
font-size: 15px;
}

.absent{
   background- color: #D95350;
}

.timee{
    background-color: #428BCA;
}

.late{
    background-color: #5DB85B;
}

.leave{
    background-color: #EFAD4D;
}

#user-details-dashboard{
    margin-left: 0;
    height: 240px;
    
}

#attendance-status-dashboard{
    height: 240px;
}

#attendance-status-dashboard h4{
    margin-top: -3px;
}


</style>

<?php
if(Yii::app()->user->getState('role') == 'exco'){
$this->menu=array(
    array('label'=>'<i class="icon-building"></i> Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i> Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i> Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    ); 

}else{
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('/Staff/payrollSheet/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    /*array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Site/AttendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-copy"></i>Salary Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>System Settings', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
*/
    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);
}
?>

<div class="page-title"><i class="icon-th"></i> Dashboard</div>

<?php 
$info = 'Welcome ' . Yii::app()->session['fname'] . '!! You have successfully been logged in.'; 
echo Yii::app()->user->setFlash('info', $info); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        //'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
             'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
               'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>



<!-- <div class="alert alert-block alert-welcome">
    <strong>Welcome <?php echo Yii::app()->session['fname']; ?>!!</strong> You have successfully been logged in. 
</div> -->

<h4><i class="icon-list-alt"></i> Basic Info</h4><hr>
<div class="container-fluid well span6 pull-left" id="user-details-dashboard">
    <div class="row-fluid">
        <div class="span2" >
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/user-pics/<?php echo $user->profile_pic; ?>" class="img-circle">
        </div>
        
        <div class="span8">
            <h3><?php echo $user->fname . " " . $user->lname?></h3>
            <h6>Email: <?php echo $user->email; ?></h6>
            <h6>Department: <?php echo Department::model()->findByPk($user->department_id)->department_name; ?></h6>
            <h6>Date Joined: <?php echo date('Y-m-d', $user->join_date); ?></h6>
            <h6><a href="<?php echo Yii::app()->createUrl('Staff/View/'.$user->staff_id);?>">More... </a></h6>
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
<div class="container-fluid well span6" id="attendance-status-dashboard">
    <h4>Today's attendance status</h4><hr>

<div class="panel time span5" style="border-radius:0; margin:0">
    <div class="panel-head">Attendance time:</div>
    <span><?php echo date('H:i a', $attendance->login); ?></span>
</div>
<div class="panel time span5" style="border-radius:0; margin-right:10px">
    <div class="panel-head">Status:</div>
    <span><?php if(strtolower($attendance->login_status) == 'late'){?>
        <font color="red"><?php echo $attendance->login_status; ?></font>
    <?php }else{ ?>
        <font color="green"><?php echo $attendance->login_status; ?></font>
   <?php } ?></span>
</div>
<div style="clear:both"></div>

</div>

<div style="clear:both"></div>

<!-- <h4><i class="icon-bar-chart"></i> Your attendance statistics this month</h4><hr> -->

<!-- <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">
        <div class="row-fluid">
            <div class="span6 status-panel timee">
                <h3><i class="icon-check"></i> 13</h3>
                <div class="foot">On Time Entries</div>
            </div>
          <div class="span6 status-panel late">   <h3><i class="icon-exclamation"></i> 8</h3>
                <div class="foot">Late entries</div></div>
        </div>
      </div>
      <div class="span6">
          <div class="row-fluid">
          <div class="span6 status-panel leave">   <h3><i class="icon-upload-alt"></i> 3</h3>
                <div class="foot">Early exits</div></div>
          <div class="span6 status-panel absent" style="background:#D95350;">   <h3><i class="icon-adn"></i> 1</h3>
                <div class="foot">Absent days</div></div>          
        </div>
      </div>
    </div>
  </div>
</div> -->

<div class="row-fluid">
    <div class="span6">
    <h4><i class="icon-bar-chart"></i> Attendance Statistics</h4><hr>
    <?php
$this->Widget('ext.highcharts.highcharts.HighchartsWidget', array(
    'options'=>array(
        'title' => array('text' => 'Attendance Statistics for '.$month),
        'xAxis' => array(
            'categories' => array('
                On time', 'Late Entry', 'Absent', 'Early Exit
            ')
        ),
        'yAxis' => array(
            'title' => array('text' => 'Number of days'),
            'min'=>0,
        ),
        'series' => array(
            array('name' => 'No of days', 'data' => array(
        $ontime, $late, $absent, $early
            )),

        ),
         'chart' => array(
     'type'=>'column',
     'height'=>'350',
     
      ),
    ),
   
));
?>
  </div>
  <div class="span6">
    <h4><i class="icon-eye-open"></i> Activity Log</h4><hr>
    <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                <th>User</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
            </thead>
            <tr>
                <td>Sumit</td>
                <td>Created Staff 10</td>
                <td>2014/12/11</td>
            </tr>
               <tr>
                <td>Sumit</td>
                <td>Created Staff 11</td>
                <td>2014/12/13</td>
            </tr>
               <tr>
                <td>Sanjay</td>
                <td>Created Allowance 'House'</td>
                <td>2014/12/11</td>
            </tr>
             <tr>
                <td>Jessica</td>
                <td>Created edited TDS</td>
                <td>2014/12/19</td>
            </tr>
             <tr>
                <td>Anil</td>
                <td>Created Staff 14</td>
                <td>2014/12/11</td>
            </tr>
             <tr>
                <td>Sumit</td>
                <td>Edited Staff 10</td>
                <td>2014/12/21</td>
            </tr>
             <tr>
                <td>Sumit</td>
                <td>Deleted Staff 10</td>
                <td>2014/12/181</td>
            </tr>
    </table>


  </div>
  
</div>


<br>








<?php
/*$this->Widget('ext.highcharts.highcharts.HighchartsWidget', array(
    'scripts' => array(
   'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
),
    'options'=>array(
        'title' => array('text' => 'No of absent days for this month'),
        'xAxis' => array(
            'categories' => array('
                Late
            ')
        ),
        'yAxis' => array(
            'title' => array('text' => 'Absent days'),
            'min'=>0,
            'max'=>15,
        ),
        'series' => array(
            array('name' => 'Absent days', 'data' => array(
         2
            )),

        ),
         'chart' => array(
            'type'=>'arearange',
            'width'=>320,
            'height'=>320
            
     
      ),
    ),
   
));*/
?>


<!-- <div class="panel time" style="border-radius:0; width: 31%;">
    <div class="panel-head" style="background: #F8F8F8; color:black">Current Time:</div>
        <div id="date" style="position:relative; top:10px">
        </div>
    <span id="clockbox" style="font-size:20px">
    </span>
</div>

<div class="panel time" style="border-radius:0; width:31%;">
    <div class="panel-head" style="background: #F8F8F8; color:black;">No. of absent days for November:</div>
    <span style="
  padding-top: 41px;
padding-bottom: 0px;
top: -15px;
position: relative;
    ">2</span>
</div>


<div class="panel time" style="border-radius:0; width:31%; margin-right: 0">
    <div class="panel-head" style="background: #F8F8F8; color:black">No. of late entries for November:</div>
    <span style="
    padding-top: 41px;
padding-bottom: 0px;
top: -15px;
position: relative;">6</span>
</div>

 -->





    <script type="text/javascript">


$( document ).ready(function() {
    

        tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

function GetClock(){
var d=new Date();
var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

     if(nhour==0){ap=" AM";nhour=12;}
else if(nhour<12){ap=" AM";}
else if(nhour==12){ap=" PM";}
else if(nhour>12){ap=" PM";nhour-=12;}

if(nyear<1000) nyear+=1900;
if(nmin<=9) nmin="0"+nmin;
if(nsec<=9) nsec="0"+nsec;

document.getElementById('date').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear;
document.getElementById('clockbox').innerHTML=""+nhour+":"+nmin+":"+nsec+ap.toLowerCase()+"";
}

window.onload=function(){
GetClock();
setInterval(GetClock,1000);
}


    });



</script>

