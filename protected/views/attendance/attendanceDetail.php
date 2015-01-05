<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-chevron-sign-left"></i>Back to reports', 'url'=>Yii::app()->controller->createUrl('/Attendance/departAttendanceReport'), 'linkOptions'=>array()),
    ); 
$staff = Staff::model()->findByPk($id);

?>

<div class="page-title"><i class="icon-calendar"></i> Attendance Report</i></div>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>

<h5 style="float:left">Attendance Report for <?php echo $staff->fname; ?> (Office time: <?php echo date('h:i a', strtotime($staff['officeTime'][0]->start_time)) . ' to ' .  date('h:i a', strtotime($staff['officeTime'][0]->end_time));?>)</h5><br>

<?php 
$model = new Attendance;
$model->staff_id = $id;
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'attendance-grid',
    'dataProvider'=>$model->thisWeekSearch1($id),
    'type'=>'striped bordered',
    'template'=>'{summary}{pager}{items}{pager}',
    'columns'=>array(
        array(
            'header'=>'S.N',
            'value'=>'$row+1',
            ),
        array(
            'header'=>'Date',
            'value'=>'$data["date"]',
            ), 
        array(
            'header'=>'Login Time',
            'value'=>'$data["login_time"]'
            ),
          array(
            'header'=>'Login Status',
            'value'=>'$data["login_status"]',
            ),
     
        array(
            'header'=>'Logout Time',
            'value'=>'(empty($data["logout_time"]) ? "-" : $data["logout_time"])'
            ),
         array(
            'header'=>'Logout Status',
            'value'=>'(empty($data["logout_time"]) ? "-" : $data["logout_status"])'
            ),
           array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{edit}',
            'buttons' => array(
                      'edit' => array(
                    'label' => 'Edit',
                    'url' => 'Yii::app()->controller->createUrl("Staff/attendanceDetail/".$data["date"])',
                    'options' => array(
                        'class' => 'btn btn-small edit-attendance',
                         'data-target'=>'#myModal',
                        'data-toggle'=>'modal',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
      
      ),
    ));

?>

<a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/Staff/printWeekAttendance/' . $id) ?>" target="_new"><i class="icon-download-alt"></i> Download as pdf</a>

<?php 

    $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Update Attendance</h4>
</div>
 
<div class="modal-body">
    <div class="json-error">
        </div>
    <div class="well">
        
        <b>Please enter the updated attendance details</b><br>
         <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'staff-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'action'=>''
        )); ?>

    <input type="hidden" name="date" value="">
    <input type="hidden" name="attendance-id" value="">
    Date: <span class="date"></span><br>
    Login Time: <br>
    <?php 
    $model1 = new Attendance;
$this->widget( 'application.extensions.timepicker.EJuiDateTimePicker', array(
    'model'     => $model1,
    'attribute' => 'login',
    'options'   => array(
        'timeOnly'   => true,
        'showHour'   => true,
        'showMinute' => true,
        'timeFormat' => 'hh:mm'
    ),
    'htmlOptions'=>array(
                        'value'=>'',
                        'style'=>'height:20px;','placeholder'=>'Login time', 'class'=>'span5'
                    ),
) ); ?><br>
  Logout Time: <br>
    <?php 
    $model1 = new Attendance;
$this->widget( 'application.extensions.timepicker.EJuiDateTimePicker', array(
    'model'     => $model1,
    'attribute' => 'logout',
    'options'   => array(
        'timeOnly'   => true,
        'showHour'   => true,
        'showMinute' => true,
        'timeFormat' => 'hh:mm'
    ),
    'htmlOptions'=>array(
                        'value'=>'',
                        'style'=>'height:20px;','placeholder'=>'Logout time', 'class'=>'span5'
                    ),
) ); ?>

 <?php echo $form->textAreaRow($model1, 'reason', array('class'=>'span8', 'rows'=>5)); ?>



   

</div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'label'=>'Update',
        'url'=>'#',
        'htmlOptions'=>array('id'=>'update-allowance'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>

</div>
</div>
 

<?php $this->endWidget(); ?>    
<?php $this->endWidget(); ?>

 
<script>
$(document).ready(function(){
    $('.edit-attendance').on('click', function(e){
        var date = $(this).attr('href').split('/')[4];
        var uid = <?php echo (int) $_GET['id']; ?>;
        $('input[name="date"]').val(date);
        $('.date').html(date);
        var form = $('.well').html();
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('/Attendance/getAttendance'); ?>",
            method: 'GET',
            dataType: 'JSON',
            data: {date: date, uid: uid},
            success: function(response){
                if(response.errors != undefined){
                    $('.json-error').show();
                    $('.well').hide();
                    $('.json-error').html(response.errors);
                }else if(response.login != undefined){
                    $('.json-error').hide();
                    $('.well').show();
                    $('input[name="Attendance[login]"').val(response.login);
                    $('input[name="attendance-id"]').val(response.aid);
                    if(response.logout != ''){
                        $('input[name="Attendance[logout]"').val(response.logout);
                    }
                }
                //$('input[name="login_time"]').val(respones.login_time);
                //$('input[name="logout_time"]').val(respones.logout_time);
            }
        });
    });
});
</script>