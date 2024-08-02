<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'article-form',
    'type' => 'vertical',
    'enableAjaxValidation' => false,
)); ?>


<div class="text-right">
    <?php $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'success',
        'label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
        'htmlOptions' => array()

    )); ?>
</div>
<?php echo $form->dropDownListGroup($model, 'article_category_id', array('wrapperHtmlOptions' => array('class' => ' col-md-6 col-sm-12'), 'widgetOptions' => array('data' => CHtml::listData(ArticleCategory::model()->findAll(), 'id', 'title'), 'htmlOptions' => array('empty' => '')))); ?>

<?php echo $form->textFieldGroup($model, 'title', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'slug-title')))); ?>

<?php echo $form->textFieldGroup($model, 'slug', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'slug-value')))); ?>

<?php echo $form->textareaGroup($model, 'teaser', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('rows' => 2)))); ?>
<?php echo $form->ckEditorGroup($model, 'content', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('rows' => 6), 'editorOptions' => array('customConfig' => 'config_page.js')))); ?>

<?php echo $form->textFieldGroup($model, 'keywords', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>

<?php echo $form->textFieldGroup($model, 'description', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>


<label class="control-label">Aktivno</label>
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
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ),

        ),
        'labelOptions' => array('label' => false)
    )
);
?>


<?php $this->endWidget(); ?>

