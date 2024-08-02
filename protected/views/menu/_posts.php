<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'menu-posts-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo CHtml::checkBoxList("AddPosts", array(), CHtml::listData($posts, 'id', 'title')); ?>


<div class="form-actions" style="text-align: center !important;">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'default',
        'label' => Yii::t('app', 'Add to Menu'),
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
