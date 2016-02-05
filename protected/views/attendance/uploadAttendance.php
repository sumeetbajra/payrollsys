<?php
$this->menu=array(
    array('label'=>'<i class="icon-th"></i>Dashboard', 'url'=>Yii::app()->controller->createUrl('/Site/index'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-building"></i>Manage departments', 'url'=>Yii::app()->controller->createUrl('/Department/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-group"></i>Manage designation', 'url'=>Yii::app()->controller->createUrl('/designation/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-tags"></i>Manage allowances', 'url'=>Yii::app()->controller->createUrl('/allowances/admin'), 'linkOptions'=>array()),
    array('label'=>'<i class="icon-search"></i>Custom search', 'url'=>Yii::app()->controller->createUrl('/Attendance/customAttendanceReport'), 'linkOptions'=>array()),
    ); 
?>


<div class="page-title">
    <i class="upload-alt"></i> Upload Attendance Data</i>
</div>
<h4>Upload staff attendance record data</h4><hr>

<form enctype="multipart/form-data" method="POST">
    <table>
        <tr>
            <td>
                Attendance Record:
            </td>
            <td>
                <input type="file" name="csvfile">
                <input type="hidden" name="file" value="csv">
            </td>
        </tr>
        <tr>
            <td>
                <hr>
                <button class="btn btn-primary" type="submit">Upload</button>
            </td>
        </tr>
    </table>
</form>