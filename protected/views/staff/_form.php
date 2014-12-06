<?php
/* @var $this StaffController */
/* @var $model Staff */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-form',
	'htmlOptions'=>array('class'=>'well'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<h5>Please fill in the following details.</h5><hr>
<?php echo $form->errorSummary($model,'Oops!!!', null,array('class'=>'alert alert-error span12')); ?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>

	 <table class="table">
<tr>
    <td><?php echo $form->labelEx($model, 'fname', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'fname', array('class'=>'span7', 'placeholder'=>'First Name')) ?></td>

    <td><?php echo $form->labelEx($model, 'lname', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'lname', array('class'=>'span7', 'placeholder'=>'Last Name')) ?></td>
</tr>    

<tr>
    <td><?php echo $form->labelEx($model, 'address', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'address', array('class'=>'span7', 'placeholder'=>'Address')) ?></td>

    <td><?php echo $form->labelEx($model, 'contact', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'contact', array('class'=>'span7', 'placeholder'=>'Contact')) ?></td>
</tr>

<tr>
     <td><?php echo $form->labelEx($model, 'marital_status', array('class'=>'')) ?></td>
    <td><?php echo $form->dropDownList($model, 'marital_status', array(''=>'--Marital Status', 'Single'=>'Single', 'Married'=>'Married', 'Divorced'=>'Divorced'), array('class'=>'span7')); ?></td>
    <td><?php echo $form->labelEx($model, 'email', array('class'=>'')) ?></td>
    <td><?php echo $form->textField($model, 'email', array('class'=>'span7',  'placeholder'=>'Email')) ?></td>
</tr>

<tr>
	<td><?php echo $form->labelEx($model,'join_date'); ?></td>
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
                        array('class' => 'span7', 'placeholder'=>'Join date', 'value'=>date('Y-m-d', time())),
                    ));
                    ?>
		
	</td>

</tr>
<tr>
<td>
		<?php echo $form->labelEx($officeTime, 'start_time'); ?></td>
		<td><?php 
$this->widget( 'application.extensions.timepicker.EJuiDateTimePicker', array(
    'model'     => $officeTime,
    'attribute' => 'start_time',
    'options'   => array(
        'timeOnly'   => true,
        'showHour'   => true,
        'showMinute' => true,
        'timeFormat' => 'hh:mm'
    ),
    'htmlOptions'=>array(
                        'value'=>(isset($officeTime->start_time) ? $officeTime->start_time : date('H:i', time())),
                        'style'=>'height:20px;','placeholder'=>'Office start time', 'class'=>'span7'
                    ),
) ); ?></td>
	
	

	
		<td><?php echo $form->labelEx($officeTime,'end_time'); ?></td>
		<td><?php 
$this->widget( 'application.extensions.timepicker.EJuiDateTimePicker', array(
    'model'     => $officeTime,
    'attribute' => 'end_time',
    'options'   => array(
        'timeOnly'   => true,
        'showHour'   => true,
        'showMinute' => true,
        'timeFormat' => 'hh:mm'
    ),
    'htmlOptions'=>array(
                        'value'=>(isset($officeTime->end_time) ? $officeTime->end_time : date('H:i', time())),
                        'style'=>'height:20px;','placeholder'=>'Office end time', 'class'=>'span7'
                    ),
) ); ?></td></tr>
<tr>
    <td><?php echo $form->labelEx($model,'department_id'); ?></td>
    <td><?php echo $form->dropDownList($model, 'department_id', $array1, array('class'=>'span7')); ?></td>
    </tr>

<tr>    <td><b>Designation</b> <span class="required">*</span></td>
    <td><?php        
    
  echo CHtml::dropDownList('designation',$model->designation, $array,
 
  array(
    'class'=>'span7',
    'prompt'=>'Select designation',
    'ajax' => array(
    'type'=>'POST', 
    'url'=>Yii::app()->createUrl('Staff/loadGrades'), //or $this->createUrl('loadcities') if '$this' extends CController
    'update'=>'#grades', //or 'success' => 'function(data){...handle the data in the way you want...}',
  'data'=>array('desig'=>'js:this.value'),
  ))); 
  ?>
 
 </td>

 <td><b>Grade <span class="required">*</span></b></td>
 <td>
<?php 
if(!empty($model->designation)){
    $data=Designation::model()->findAllByAttributes(array('designation'=>$model->designation));
    $data=CHtml::listData($data,'grade','grade');
echo CHtml::dropDownList('grades', $model->grade, $data, array('prompt'=>'Select grade', 'class'=>'span7'));

}else{
    echo CHtml::dropDownList('grades', $model->grade, array(), array('prompt'=>'Select grade', 'class'=>'span7'));

}
?></td>
</tr>

</table>

<p class="note">Fields with <span class="required">*</span> are required.</p>
   <?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'id' => 'sbutton','type'=>'success', 'label'=>'Create')); ?>
   
   
           <?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-input-small'))); ?></td><td></td>

    <?php $this->endWidget(); ?>


	


