
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'gallery-lang-form',
        'type'=> 'vertical',
	'enableAjaxValidation'=>false,
)); ?>
<div class="text-right">
<?php $this->widget('booster.widgets.TbButton', array(
    'buttonType'=>'submit',
    'context'=>'success',
    'label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
    'htmlOptions' => array(
    'name'=>'Language['.$lang.']',
    )

)); ?>
</div>


<?php echo $form->textFieldGroup($model,'title'.$lang,array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'class'=>'slug-title')))); ?>

<?php echo $form->textFieldGroup($model,'slug'.$lang,array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255,'class'=>'slug-value')))); ?>

<?php echo $form->textAreaGroup($model,'description'.$lang,array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('rows' => 6)))); ?>


<?php $this->endWidget(); ?>
