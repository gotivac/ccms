<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'gallery-form',
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


<?php echo $form->textFieldGroup($model, 'title', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'slug-title')))); ?>

<?php echo $form->textFieldGroup($model, 'slug', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'slug-value')))); ?>

<?php echo $form->textAreaGroup($model, 'description', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('rows' => 6)))); ?>

<label class="control-label"><?=Yii::t('app','Active');?></label>
<?php
echo $form->switchGroup($model, 'active', array(
        'widgetOptions' => array(
            'events' => array(
                'switchChange' => 'js:function(event, state) {
							console.log(this); // DOM element
							console.log(event); // jQuery event
							console.log(state); // true | false
							}',
            ),
            'options' => array(
                'onText' => Yii::t('app','Yes'),
                'offText' => Yii::t('app','No'),

            ),

        ),
        'labelOptions' => array(
            'label' => false
        )

    )
);
?>
<?php $this->endWidget(); ?>
