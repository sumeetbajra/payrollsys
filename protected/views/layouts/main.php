<!DOCTYPE html>
<html>
<head>
</head>

<body>
    <div id="body-wrapper">


<div class="page">
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="span2" id="mid" >
                   
                </div>
                <div class="pull-left">
                    <div class="span10">
                        <?php 

                        $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                        'homeLink'=>CHtml::link('Dashboard', array('/site/index')),
                         'links'=>$this->breadcrumbs,
                        )); ?>

                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clear:both; height:78px"></div>
</div><!--main container wrapper div ends-->


</body>
</html>


  <style>
       