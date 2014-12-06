<style>
.table tr td{
    border-top: none;
}

.table label{
    font-weight: bold;
}
</style>

<div class="page-title"><i class="icon-pencil"></i> Change your username and password</div>

<h5>Please type your new password</h5><hr>

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'action'=>'',
        'method'=>'POST',
        //'id'=>'edit-user-form',
        'htmlOptions'=>array('enctype' => 'multipart/form-data', 'class'=>'well', 'autocomplete'=>'off'),
        ));
    ?>
    <?php echo $form->errorSummary($model,'Oops!!!', null,array('class'=>'alert alert-error span12')); ?>

    <table class="table">
<tr>
    <td style="width:150px; text-align:right"><?php echo $form->labelEx($model, 'password', array('class'=>'')) ?></td>
    <td><?php echo $form->passwordField($model, 'password', array('class'=>'span7', 'placeholder'=>'Password', 'value'=>'')) ?></td>
</tr>    

<tr>
    <td style="text-align:right"><?php echo CHtml::label('Re-type password <font color="red">*</font>', '', array('class'=>'')) ?></td>
    <td><?php echo CHtml::passwordField('password', '', array('class'=>'span7', 'placeholder'=>'Re-type your password', 'value'=>'')) ?></td>
</tr>    
</table>
   <?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'id' => 'sbutton','type'=>'success', 'label'=>'Change')); ?>
   
   
           <?php $form->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-input-small'))); ?></td><td></td>



    <?php $this->endWidget(); ?>
    