<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="page-title"><i class="icon-warning-sign"></i> Error <?php echo $code; ?></div>

<div class="alert error">
<?php echo CHtml::encode($message); ?>
</div>

If you believe you shouldn't be seeing this message, please contact the HR department.<br>
Click <u><a href="<?php echo $_SERVER['HTTP_REFERER'];?>">here</a></u> to go back.