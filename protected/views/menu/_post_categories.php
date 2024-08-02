<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'menu-post-categories-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo CHtml::checkBoxList("AddPostCategories", array(), CHtml::listData($post_categories, 'id', 'title')); ?>


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
