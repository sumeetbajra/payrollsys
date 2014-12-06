

<?php
/* @var $this StaffController */
/* @var $model Staff */

/*$this->breadcrumbs=array(
	'Staff'=>array('index'),
	$model->staff_id,
);*/

$this->menu=array(
    array('label'=>'<i class="icon-user"></i> Manage Staff', 'url'=>array('admin')),
    array('label'=>'<i class="icon-plus"></i> Create Staff', 'url'=>array('create')),
    array('label'=>'<i class="icon-edit"></i> Update Staff', 'url'=>array('update', 'id'=>'')),
    array('label'=>'<i class="icon-trash"></i> Delete Staff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>''),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'<i class="icon-arrow-left"></i> Back', 'url'=>array('admin')),
);
?>

<div class="page-title"><i class="icon-th-list"></i> Complete Staff Detail</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array(
        'Manage Staff' => array('/Staff/admin'),
        'View Staff'
))); ?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Basic Info', 'icon'=>'icon-user', 'url'=>Yii::app()->createUrl('Staff/view/'.$id)),
        array('label'=>'Allowances', 'icon'=>'icon-money', 'active'=>true, 'url'=>'#'),
    ),
)); 

$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    ));

$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'allowance-grid',
    'dataProvider'=>$allowances,
    'type'=>'striped bordered',
    'template'=>'{pager}{items}{pager}{summary}',
    'columns'=>array(
        array(
            'header'=>'S.N',
            'value'=>'$row+1',
            ),
        array(
            'header'=>'Allowance',
            'value'=>'$data["allowanceName"]',
            ),
       'percentage: Percentage',
         array(
            'header'=>'<a>Actions</a>',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                      'update' => array(
                    'label' => 'Update',
                    'url' => 'Yii::app()->controller->createUrl("a/b/".$data["id"])',
                    'options' => array(
                        'class' => 'btn btn-small update updatee',
                        'data-target'=>'#myModal1',
                        'data-toggle'=>'modal',
                    )),
                      'delete' => array(
                    'label' => 'Delete',
                    'url' => 'Yii::app()->controller->createUrl("Staff/deleteStaffAllowance/".$data["id"])',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    )),

            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
        ),
         /*array(
           'class' => 'editable.EditableColumn',
           'name' => 'allowance.allowanceName',
           'value'=>'CHtml::value($data, "allowance.allowanceName")',
           'headerHtmlOptions' => array('style' => 'width: 110px'),
            'editable' => array(    //editable section
                  'url'        => $this->createUrl('site/updateUser'),
                  'placement'  => 'right',
              )               
        ),
*/
       
      ),
    ));
?>

<?php 

    $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal1')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Update Allowance</h4>
</div>
 
<div class="modal-body">
    <div class="well">
        Please enter the new allowance rate:<br>
        <form>
    <input type="text" name="uallowance">
    <input type="hidden" name="aid" value="">

</div>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Update',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'update-allowance'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
    </form>
</div>
<?php $this->endWidget(); ?>
 

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Add new',
    'type'=>'primary',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#myModal',
    ),
)); 
?>
    


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Add Allowance</h4>
</div>
 
<div class="modal-body">
    <table class="table well">
        <tr>
            <td>Allowance</td>
            <td>Percentage</td>
        </tr>
        <tr>
            <td><?php 

            echo CHtml::dropDownList('allowance', '', CHtml::listData(StaffAllowance::model()->getRemStaffAllowances($id), 'allowanceId', 'allowanceName'), array('prompt'=>'--Select Allowance--')); ?>
            </td>
            <td>
                <input type="number" name="percentage" placeholder="Allowance percentage">
                <input type ="hidden" name="id" value="<?php echo $id?>">
            </td>
        </tr>
    </table>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Add',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'add-allowance'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>