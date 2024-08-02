<div class="col-md-8 col-md-offset-2">
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'article-category-form',
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



<?php echo $form->dropDownListGroup($model, 'parent_id', array('wrapperHtmlOptions' => array('class' => ' col-md-6 col-sm-12'), 'widgetOptions' => array('data' => CHtml::listData(ArticleCategory::model()->findAll(array('condition' => 'title !="' . $model->title . '"')), 'id', 'title'), 'htmlOptions' => array('empty' => '')))); ?>

<?php echo $form->textFieldGroup($model, 'title', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'slug-title')))); ?>

<?php echo $form->textFieldGroup($model, 'slug', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'slug-value')))); ?>


<?php $this->endWidget(); ?>
</div>