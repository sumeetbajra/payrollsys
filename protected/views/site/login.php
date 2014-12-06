  <?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>
<style>
.submit input{
  cursor: pointer;
}

body{
  overflow:hidden;
}

.body{
  position: absolute;
  top: -20px;
  left: -20px;
  right: -40px;
  bottom: -40px;
  width: auto;
  height: auto;
  background-image: url(../../images/a.jpg);
  background-size: cover;
  -webkit-filter: blur(5px);
  z-index: -1;
}
</style>
<div class="body"></div>
<section class="container">
    <div class="login">
      <h1>Payroll and Attendance System</h1>
      <?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>
        <font color="green">  <?php 
          echo Yii::app()->user->getFlash('success');
          ?></font>
        <font style="color: rgb(255, 88, 88)"><?php echo $form->error($model,'username',array('class'=>'error')); ?>
        <?php echo $form->error($model,'password',array('class'=>'error')); ?></font>
        <p><?php echo $form->textField($model,'username'); ?></p>
        <p>  <?php echo $form->passwordField($model,'password'); ?></p>
        <p class="remember_me">
          <label>
             <?php echo $form->checkBox($model,'rememberMe'); ?>
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><?php echo CHtml::submitButton('Login'); ?></p>
      </form>
    </div>

    <div class="login-help">
      <p>Forgot your password? <a href="#" data-target='#myModal' data-toggle='modal'>Click here to reset it</a>.</p>
    </div>
  </section>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
<div class="modal-header" style="background: #0081A8; color:white">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 style="text-transform:none">Reset username and password</h4>
</div>
 
<div class="modal-body" style="line-height:30px">
<div class="well">
  <div class="error"></div>
    <div id="password">
    Please enter your username:<br>
    <?php echo CHtml::textField('username', '', array('class'=>'span4')); ?>
  </div>
  <div id="email-notify"></div>
</div>
</div>
 
<div class="modal-footer" style="border-radius:0">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'submit',
        'label'=>'Proceed',
        'id' => 'proceed',
        'url' => Yii::app()->createUrl('/Staff/forgotPassword'),
        'htmlOptions'=>array('class'=>'btn-primary'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'id'=>'close',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<script>
$(document).ready(function(){
  $('#close').on('click', function(){
    $('.error').html('');
    $('#password').show();
    $('#email-notify').html('');
    $('input[name="username"]').val('');
  });

  $('#proceed').on('click', function(e){
    var username = $('input[name="username"]').val();
    if(username != ''){
      $.ajax({
        url: 'checkUser',
        data: {username: username},
        method: 'GET',
        success: function(response){
          if(response != "false"){
            console.log(response);
           $('#email-notify').html('A reset link will be sent to your email address below:<br>' + response);
           $('.error').html('');
           $('#password').hide();
           $('.modal-footer .btn').hide();
           window.location = '../Password/forgotPassword?email='+response;
           setTimeout(function() {
              $('#myModal').modal('hide');
            }, 5000);
          }else{
            $('.error').html('<font color="red"><b>Sorry, the username could not be found.</b></font>');
            $('input[name="username"').val('');
          }
        }
      });
    }
    e.preventDefault();
  });
});
</script>