<style>
.table tr td{
	border-top:none
}
</style>

<?php
/* @var $this StaffController */
/* @var $model Staff */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	 <table class="table table-responsive">
<tr>  
    <td><?php echo $form->textField($model, 'fname', array('class'=>'', 'placeholder'=>'First Name')) ?></td> 
    <td><?php echo $form->textField($model, 'lname', array('class'=>'', 'placeholder'=>'Last Name')) ?></td>
    <td><?php echo $form->textField($model, 'address', array('class'=>'', 'placeholder'=>'Address')) ?></td>
    <td><?php echo $form->textField($model, 'contact', array('class'=>'', 'placeholder'=>'Contact')) ?></td>
</tr>

<tr>
    <td><?php echo $form->textField($model, 'email', array('class'=>'',  'placeholder'=>'Email')) ?></td>
    <td><?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'join_date',
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'showAnim' => 'drop',
                            'dateFormat' => 'yy-mm-dd',
                            'changeYear' => true,
                            'changeMonth' => true,
                            'yearRange' => '1900:',
                        ),
                        'htmlOptions' => 
                        array('class' => '', 'placeholder'=>'Join date'),
                    ));
                    ?>		
	</td>
	<td><?php echo $form->dropDownList($model, 'department_id', $array1, array('class'=>'')); ?></td>
  	<td><?php           
  		echo CHtml::dropDownList('designation',$model->designation, $array,
		  array(
		    'class'=>'',
		    'prompt'=>'Select designation',
		    'ajax' => array(
		    'type'=>'POST', 
		    'url'=>Yii::app()->createUrl('Staff/loadGrades'), //or $this->createUrl('loadcities') if '$this' extends CController
		    'update'=>'#grades', //or 'success' => 'function(data){...handle the data in the way you want...}',
		  'data'=>array('desig'=>'js:this.value'),
		  ))); 
		  ?>
	</td></tr><tr>
 	<td>
	<?php echo CHtml::dropDownList('grades', $model->grade, array(), array('prompt'=>'Select grade', 'class'=>'')); ?>
	</td>

	<td><?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'id' => 'sbutton','type'=>'primary', 'label'=>'Search')); ?> 
		<?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'id' => 'sbutton','type'=>'null', 'label'=>'Reset')); ?></td>
</tr>

</table>

<?php $this->endWidget(); ?>

</div>