<?php

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
        ));
?>



<?php echo $form->textFieldGroup($model, 'name', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'email', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'phone', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>

<?php if ($model->isNewRecord): ?>
    <?php echo $form->textFieldGroup($model, 'password', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)))); ?>
<?php else: ?>
    <div class="form-group">
        <label class="col-sm-3 control-label required"><?php echo Yii::t('app', 'Change password'); ?> </label>
        <div class="col-md-6 col-sm-12 col-sm-9">
            <input type="text" id="new" name="Password[password]" class="form-control"/>
        </div>
    </div>
<?php endif; ?>


<?php // echo $form->dropDownListGroup($model, 'roles', array('wrapperHtmlOptions' => array('class' => ' col-md-6 col-sm-12'), 'widgetOptions' => array('data' => array('administrator' => Yii::t('app', 'Administrator'), 'user' => Yii::t('app','User')), 'htmlOptions' => array('empty' => '')))); ?>


<?php echo $form->textAreaGroup($model, 'notes', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('rows' => 6)))); ?>
<?php // echo $form->ckEditorGroup($model, 'notes', array('wrapperHtmlOptions' => array('class' => 'col-md-6 col-sm-12'), 'widgetOptions' => array('htmlOptions' => array('rows' => 6), 'editorOptions' => array('customConfig'=> 'config.js')))); ?>

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

<div class="form-actions text-right col-md-9">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' =>  Yii::t('app', 'Save'),
    ));
    ?>
</div>

<?php $this->endWidget(); ?>


