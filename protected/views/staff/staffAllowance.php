<style>
form .table tbody tr td{
    border-top: none;
    vertical-align: middle;
    
}

form .table tbody tr td:nth-child(2){
    text-align: left;
}

form .table label{
    font-weight: bold;
}

input[type="number"]{
    position: relative;
    top: 5px;
}
</style>
<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Staff'=>array('index'),
	'Allowances',
);

$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.Yii::app()->session['uid']), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-sitemap"></i>Manage Staffs <i class="icon-sort-down pull-right"></i>', 'url'=>'#',  'active'=>'true', 'linkOptions'=>array('class'=>'main-menu')),
    array('label'=>'<i class="icon-plus"></i>Add Staffs', 'url'=>Yii::app()->controller->createUrl('/Staff/create'), 'linkOptions'=>array('class'=>'sub-menu')),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),   
   
    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);

?>


<div class="page-title"><i class="icon-money"></i> Allocate Allowances</div>
<!-- <a href="<?php echo Yii::app()->createUrl('/Staff/admin'); ?>"> <i class="icon-arrow-left"></i> Go Back</i></a><br><br> -->

<form action ="<?php echo Yii::app()->createUrl('Staff/staffAllowance/'.$id); ?>" method="POST">
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>S.N</td>
            <td>Allowance</td>
            <td>Status</td>
            <td>Percentage</td>
        </tr>
    </thead>
    <?php 
    $allowances = Allowances::model()->findAll();
    foreach ($allowances as $key => $allowance) { ?>
    <tr>
        <td><?php echo $key + 1;?></td>
        <td><?php echo $allowance->allowanceName; ?></td>
        <td><input type="checkbox"  class="allowance-checkbox"></td>
        <td><input type="number" name="<?php echo $allowance->allowanceId; ?>" disabled></td>

    </tr>
        
    <?php } ?>
</table>
<button type="submit" class="btn-primary btn-small" name="allowance-btn" value="save">Save</button>
</form>


