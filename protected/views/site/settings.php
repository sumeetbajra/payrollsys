<?php if(Yii::app()->user->getState('role') == 'superadmin'){
$this->menu=array(
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    ); 

}else{
    $user = Staff::model()->findByPk(Yii::app()->session['uid']);
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-user"></i>User Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Details', 'url'=>Yii::app()->controller->createUrl('/Staff/'.$user->staff_id), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Staff/attendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>Settings', 'active'=>'true', 'url'=>Yii::app()->controller->createUrl('/Site/Settings'), 'linkOptions'=>array()),
    /*array('label'=>'<i class="icon-calendar"></i>Attendance Report', 'url'=>Yii::app()->controller->createUrl('/Site/AttendanceReport'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-copy"></i>Salary Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-file-text-alt"></i>Payroll Sheet', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-gears"></i>System Settings', 'url'=>Yii::app()->controller->createUrl('#'), 'linkOptions'=>array()),
*/
    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),*/

);
}
?>

<div class="page-title"><i class="icon-gears"></i> System Settings</div>


<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Setting'        
))); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        //'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
             'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>


<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Change system settings'),
        array('label'=>'Edit User details', 'icon'=>'user', 'url'=>Yii::app()->createUrl('/Staff/edit/'.Yii::app()->session["uid"]), 'linkOptions'=>array()),
        array('label'=>'Change password', 'icon'=>'key', 'url'=>'#', 'linkOptions'=>array('data-target'=>'#myModal', 'data-toggle'=>'modal')),
        //array('label'=>'User log', 'icon'=>'icon-eye-open', 'url'=>'', 'linkOptions'=>array('id'=>'time')),
        array('label'=>'Change Provident Funds', 'icon'=>'icon-inr', 'url'=>Yii::app()->createUrl('/Site/changePf')),
         array('label'=>'Manage TDS Rates', 'icon'=>'icon-bar-chart', 'url'=>Yii::app()->createUrl('/TdsRate/admin')),
    ),
));?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 style="text-transform:none">Reset password</h4>
</div>
 
<div class="modal-body">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'add-cons-form',
        'enableAjaxValidation'=>true,
        'method'=>'post',
        'type'=>'inline',
        'htmlOptions'=>array(
            'enctype'=>'multipart/form-data',
            'class' => 'well'
        )
    )); ?>
<div id="error-password"></div><div id="error-password1"></div><div id="error-password2"></div>
<div id ="password-left">
Please enter your current password:<br>
<?php echo CHtml::passwordField('pass', '', array('class'=>'span5', 'id'=>'reset-password')) ?>
</div>

<div id="password-right">
    <h5>Type your new password</h5>
   New password: <br><?php echo CHtml::passwordField('password', '', array('class'=>'span5', 'placeholder'=>'New password')) ?><br>
   Re-type password: <br><?php echo CHtml::passwordField('repassword', '', array('class'=>'span5', 'placeholder'=>'Re-type new password')) ?>
</div>

</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'submit',
        'label'=>'Proceed',
         'id'=>'swipe-right',
        //'url' => Yii::app()->createUrl('/Staff/forgotPassword'),
        'htmlOptions'=>array('class'=>'btn-primary'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<script>
$(document).ready(function(){
    $('#swipe-right').on('click', function(e){
        var password = $('#reset-password').val();
        if(password != ''){
            $.ajax({
            data: {password: password},
            method: 'GET',
            url: '../Site/changePassword',
            success: function(response){
                if(response == 'true'){
                      $('#password-left').hide();
                      $('#error-password').html('');
                      $('#password-right').show();
                      $('#swipe-right').addClass('correctPassbtn');
                }else if(response == 'false'){
                    $('#error-password').html('<font color="red"><b>Sorry, you have typed incorrect password. Try again!</b></font>');
                    $('#reset-password').val('');
                }
            }
         });
        }
        e.preventDefault();
    });

    $('.modal-footer').on('click', '.correctPassbtn', function(){
         var password = $('input[name="password"]').val();
        if(password === $('input[name="repassword"]').val() && password != ''){
             $.ajax({
            data: {password: password},
            method: 'GET',
            url: '../Site/changePasswordAjax',
            success: function(response){
                if(response == 'true'){
                    location.reload();
                }else{
                    $('#error-password1').html('<font color="red"><b>Sorry, there was a problem. Try again later!</b></font>');
                    $('input').val('');                
                }
            }
         });
        }else{
            $('#error-password2').html('<font color="red"><b>Password mismatch.</b></font>');
             $('input').val('');                
        }
    });
});
</script>