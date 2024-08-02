<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'attachment-form',
    'type'=> 'horizontal',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>



    <label class="control-label required">Naziv</label>
<?php echo CHtml::textField('DownloadAttachment[title]','',array('class'=>'form-control')); ?>


<?php echo CHtml::fileField('attachment','',array()); ?>


    <div class="form-actions">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label' => Yii::t('app', 'Upload'),
        )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>