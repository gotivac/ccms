
<div class="col-md-8 col-md-offset-2">
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'page-form',
    'type' => 'vertical',
    'enableAjaxValidation' => false,
)); ?>

    <div class="text-right">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'success',
            'label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
            'htmlOptions' => array(

            )

        )); ?>
    </div>

<?php echo $form->textFieldGroup($model, 'title'.$lang, array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>

<?php echo $form->textFieldGroup($model, 'slug'.$lang, array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>



<?php $this->endWidget(); ?>
</div>

