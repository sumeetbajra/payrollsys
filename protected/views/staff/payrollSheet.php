<style>
table tr td:nth-child(2), table tr td:nth-child(4){
	text-align: right;
}
</style>

<?php

include('numberToWord.php');

if(Yii::app()->user->getState('role') == 'superadmin'){
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-chevron-sign-left"></i>Back', 'url'=>Yii::app()->controller->createUrl('/staff/staffPayroll'), 'linkOptions'=>array()),
    ); 
}else{
    $user = Staff::model()->findByPk(Yii::app()->session['uid']);
    $this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('/Staff/payrollSheet/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    );
}
?>

<div class="page-title"><i class="icon-file-text-alt"></i> Payroll Sheet</i></div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Staff Payroll' => array('staff/staffPayroll'),
        $staff->fname. ' '. $staff->lname,
))); ?>

<h4>Payroll sheet for <?php echo $staff->fname, ' ', $staff->lname;?> for the month of <?php echo date('F', time()); ?></h4><hr>

<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">
        <table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<td>
				Earnings
			</td>
			<td>
			</td>
		</tr>
	</thead>
	<tr>
		<td>
			Basic Salary:
		</td>
		<td> Rs. 
			<?php  
            			echo number_format((float)$salary, 2, '.', '');
            		?>
		</td>
	</tr>
	<tr>
		<td>
			PF/C:
		</td>
		<td>
			Rs. <?php echo number_format((float)$pfc, 2, '.', '');?>
		</td>
	</tr>
	  <?php foreach($allowances as $allowance){ ?>
            	<tr>
            		<td>
            			<?php echo $allowance->allowanceName; ?>
            		</td>
            		<td>Rs. 
            			<?php 
            				$all = $staff->getAllowances($staff->staff_id, $allowance->allowanceId,  time()) * $salary/100 ; 
            				echo number_format((float)$all, 2, '.', '');
            				$gtotal += $all;
         				?>
         			</td>
            	</tr>
            <?php } ?>

	<tr>
		<td>
			Total earning:
		</td>
		<td>
			Rs. <?php $gsalary = $gtotal + $salary + $pfc;
				 echo number_format((float)$gsalary, 2, '.', '');
			 	?>
		</td>
	</tr>

</table>

      </div>
      <div class="span6">
      	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<td>Deductions</td>
			<td></td>
		</tr>
	</thead>

	<tr>
		<td>
			PF
		</td>
		<td>
			Rs. <?php $pfc = $staff->getPf(time()) * $salary/100; 
				echo number_format((float)$pfc, 2, '.', '');
				?>
		</td>
	</tr>
	<tr>
		<td>
			Self Pf
		</td>
		<td>
			Rs. <?php echo $selfpf = $staff->getSelfPf($staff->staff_id, time()); ?>
		</td>
	</tr>
	<tr>
		<td>
			Absense
		</td>
		<td>
			Rs. <?php echo $absent = $staff->getAbsentDays($staff->staff_id, time()); ?>
		</td>
	</tr>
	<tr>
		<td>
			Advance
		</td>
		<td>
			Rs. 0.00
		</td>
	</tr>
	<tr>
		<td>
			TDS
		</td>
		<td>
			Rs. <?php 
				$tds = $staff->getTdsRate($staff->staff_id, $gsalary); 
				echo number_format((float)$tds, 2, '.', '');
			?>
		</td>
	</tr>
	<tr>
		<td>
			Others
		</td>
		<td>
			Rs. 0.00
		</td>
	</tr>
	<tr>
		<td>
			Total deduction:
		</td>
		<td>
			Rs. <?php echo $tdeduction = $selfpf + $tds + $absent;?>
		</td>
	</tr>

</table>
      </div>
    </div>
  </div>
</div>




<div style="clear:both"></div>
<table class="table table-bordered table-condensed">
	<tr>
		<td colspan="6" style="text-align:right">
			<b>Net Salary: Rs. <?php echo $gsalary-$tdeduction ?></b>
		</td>
	</tr>
	<tr>
		<td colspan="6" style="text-align:right">
			<?php
			$amount = $gsalary-$tdeduction;
			$obj    = new toWords($amount);
			$word = (string) $obj->words;
			echo ucfirst(ltrim($word)), ' only /-', '&nbsp;&nbsp;&nbsp;';
			//echo str_replace(substr($word, 2, 1), strtoupper(substr($word, 2, 1)), $word); // gives twelve thousand three hundred and forty five  pounds  sixty seven  p
			?>
		</td>
	</tr>
</table>