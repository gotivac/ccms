<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'menu-job-guides-form',
    'type' => 'vertical',
    'enableAjaxValidation' => false,
        ));
?>


<?php echo $form->textFieldGroup($custom_link, 'title', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>

<?php echo $form->textFieldGroup($custom_link, 'link', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>



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