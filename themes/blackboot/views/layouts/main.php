<?php
	Yii::app()->clientscript->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery.js', CClientScript::POS_END );
	Yii::app()->clientscript->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery.cookie.js', CClientScript::POS_END );
	Yii::app()->clientscript->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery.circliful.min.js', CClientScript::POS_END );

		// use it when you need it!
		/*
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
		->registerCoreScript( 'jquery' )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-transition.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-alert.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-dropdown.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-scrollspy.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tab.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tooltip.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-popover.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-button.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-collapse.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-carousel.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-typeahead.js', CClientScript::POS_END )
		*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="language" content="en" />
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- Le styles -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.circlify.css" rel="stylesheet" type="text/css" />
<!-- Le fav and touch icons -->
<style>
.navbar .navbar-inner {
background: #f5f5f5;
}

/*.nav-collapse .nav li a{
	color: white;
}*/


.footer{
	background:#065DA8;
	box-shadow: inset 0 1px 0 #065DA8;
	color: white;
	border-top: solid thin #065DA8;
}

a.dropdown-toggle + #yw2 li a{
	color: black;
}

a.dropdown-toggle + #yw2 li a:hover{
	color: white;
}
</style>
</head>

<body>
	<div class="body"></div><div class="clear"></div>
	
	<div class="cont">
	<div class="container-fluid">
	  <?php /*if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'homeLink'=>false,
				'tagName'=>'ul',
				'separator'=>'',
				'activeLinkTemplate'=>'<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
				'inactiveLinkTemplate'=>'<li><span>{label}</span></li>',
				'htmlOptions'=>array ('class'=>'breadcrumb')
			));*/ ?>
		<!-- breadcrumbs -->
	  <?php //endif?>
	
	<?php echo $content ?>
	
	
	</div><!--/.fluid-container-->
	</div>
		
	<div class="footer">
	  <div class="container">
		<div class="row">
			<div id="footer-copyright" class="col-md-6">
				
			</div> <!-- /span6 -->
			<div id="footer-terms" class="col-md-6">
				<a id="back-to-top" href="#" class="btn btn-null btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="icon-chevron-sign-up"></span></a>
				© 2014 All Rights Reserved. <a href="http://nachi.me.pn" target="_blank">Sumit Bajracharya</a>.
			</div> <!-- /.span6 -->
		 </div> <!-- /row -->
	  </div> <!-- /container -->
	</div>
</body>
</html>
