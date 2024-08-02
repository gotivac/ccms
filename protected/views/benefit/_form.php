<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'benefit-form',
        'type'=> 'horizontal',    
	'enableAjaxValidation'=>false,
)); ?>





	<?php echo $form->textFieldGroup($model,'title',array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

	<?php echo $form->textAreaGroup($model,'description', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('rows'=>6)))); ?>

	<?php echo $form->textFieldGroup($model,'address',array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'phone',array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

	<?php echo $form->textFieldGroup($model,'website',array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'),'widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

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
    )
    ),

        )
);
?>
<?php $this->endWidget(); ?>
