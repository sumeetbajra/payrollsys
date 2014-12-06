<style>
.btn-group{
    position: relative;
    right: 35px;
}

#user-details-dashboard{
    margin-left: 0;
    margin-right: 20px;
}

#attendance-status-dashboard{
    margin-left: 0;
}

#attendance-status-dashboard h4{
    margin-top: -3px;
}


</style>

<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>My Details', 'url'=>Yii::app()->controller->createUrl('Site/Staff/'.Yii::app()->session['uid']), 'linkOptions'=>array()),
  

    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);
?>

<div class="page-title"><i class="icon-th"></i> Dashboard</div>

<div class="alert alert-block alert-welcome">
    <strong>Welcome <?php echo Yii::app()->session['fname']; ?>!!</strong> You have successfully been logged in. 
</div>

<div class="container-fluid well span6" id="user-details-dashboard">
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
                    <li><a href="#"><span class="icon-trash"></span> Delete</a></li>
                </ul>
            </div>
        </div>
</div>
</div>
<div class="container-fluid well span6 pull-right" id="attendance-status-dashboard">
    <h4>Today's attendance status</h4><hr>

<div class="panel time" style="border-radius:0;">
    <div class="panel-head">Attendance time:</div>
    <span><?php echo date('H:i a', $attendance->login); ?></span>
</div>
<div class="panel time" style="border-radius:0; margin-right:0">
    <div class="panel-head">Status:</div>
    <span><?php if(strtolower($attendance->status) == 'late'){?>
        <font color="red"><?php echo $attendance->status; ?></font>
    <?php }else{ ?>
        <font color="green"><?php echo $attendance->status; ?></font>
   <?php } ?></span>
</div>

</div>
<div style="clear:both"></div>
<div class="panel time" style="border-radius:0; width: 31%;">
    <div class="panel-head" style="background: #F8F8F8; color:black">Current Time:</div>
        <div id="date" style="position:relative; top:10px">
        </div>
    <span id="clockbox" style="font-size:20px">
    </span>
</div>

<div class="panel time" style="border-radius:0; width:31%;">
    <div class="panel-head" style="background: #F8F8F8; color:black;">No. of absent days for October:</div>
    <span style="
  padding-top: 41px;
padding-bottom: 0px;
top: -15px;
position: relative;
    ">2</span>
</div>


<div class="panel time" style="border-radius:0; width:31%; margin-right: 0">
    <div class="panel-head" style="background: #F8F8F8; color:black">No. of late entries for October:</div>
    <span style="
    padding-top: 41px;
padding-bottom: 0px;
top: -15px;
position: relative;">6</span>
</div>







    <script type="text/javascript">
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
</script>

