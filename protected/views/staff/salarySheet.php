<div class="page-title"><i class="icon-usd"></i> View Salary Sheet</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
    	'Salary Sheet',
))); ?>

<h4>
	<?php if(!empty($depart)) echo Department::model()->findByPk($depart)->department_name," department salary sheet"; else echo "Department wise salary sheet"; ?></h4> <hr>

<form action="" method="POST">
<?php echo CHtml::dropDownList('depart', '', CHtml::listData(Department::model()->findAll(), 'department_id', 'department_name'), array('prompt'=>'--Select department--')); ?>&nbsp;
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Submit',
    'buttonType'=>'submit', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'htmlOptions'=>array('id'=>'depart-submit'),
)); ?>
</form>
<br>
<?php $allowances = Allowances::model()->findAll(); ?>
<table class="table table-bordered table-striped" id="payroll">
    <thead>
        <tr>
            <th rowspan="3">S.N</th>
            <th rowspan="3">Full Name</th>
            <th rowspan="3">Designation</th>
     	<th colspan="3">Salary</th>
            <th colspan="<?php echo count($allowances); ?>">Allowances</th>
            <th rowspan="3">G.Total</th>
            <th colspan="6">Deductions</th>
            <th rowspan="3"> Total</th>            
            <th rowspan="3"> Net payment</th>            
        </tr>
        <tr>
            <th> Basic </th>
            <th> Grade </th>
            <th> PF/C </th>
        
            <?php foreach($allowances as $allowance){ ?>
            	<th><?php echo $allowance->allowanceName; ?></th>
            <?php } ?>
            <th>P/F</th>
            <th>Self P/F</th>
            <th>TDS</th>
            <th>Advance</th>
            <th>Absense</th>
            <th>Others</th>
        </tr>
    </thead>
    <tbody>
    	<?php 
    	$ntotal = 0;
    	if(!empty($staffs)){    		
    	foreach ($staffs as $key => $staff) { 
    		$gtotal = 0;    		
    		?>
    		
    	
        <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $staff->fname, " ", $staff->lname; ?></td>
            <td><?php echo $designation = Designation::model()->findByPk($staff->designation_id)->designation; ?></td>
            <td><?php echo $salary = Designation::model()->findByPk($staff->designation_id)->salary; ?></td>
            <td><?php echo $grade = Designation::model()->findByPk($staff->designation_id)->grade; ?></td>
            <td><?php echo $pfc = $model->getPfc(time()) * $salary/100; ?></td>
             <?php foreach($allowances as $allowance){ ?>
            <td><?php echo $all = $model->getAllowances($staff->staff_id, $allowance->allowanceId,  time()) * $salary/100 ; 
            $gtotal += $all;
            ?></td>
            <?php } ?>
            <td><?php echo $gsalary = $gtotal + $salary + $pfc; ?></td>
           
            <td><?php echo $pfc = $model->getPf(time()) * $salary/100; ?></td>
            <td><?php echo $selfpf = $model->getSelfPf($staff->staff_id, time()); ?></td>
            <td><?php echo $tds = $model->getTdsRate($staff->staff_id, $gsalary); ?></td>
            <td><?php echo $advance = 0; ?></td>
            <td><?php echo $absent = $model->getAbsentDays($staff->staff_id, time()); ?></td>
            <td><?php echo $others = 0; ?></td>
            <td><?php $tdeduction = $selfpf + $tds + $advance + $absent + $others; echo $tdeduction;?></td>
            <td><?php echo $nsalary = $gsalary - $tdeduction; $ntotal += $nsalary; ?></td>
        </tr>
        <?php }  }?>
        <tr>
        	<td  colspan="19">Net Total:</td><td style="text-align: right"><?php echo $ntotal; ?></td>
        </tr>      
    </tbody>
</table>


