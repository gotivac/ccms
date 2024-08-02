<?php
$this->breadcrumbs=array(
	Yii::t('app','Downloads')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('app','Update'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'List'), 'url' => array('index'), 'linkOptions' => array('class' => 'btn-primary')),
	array('label' => Yii::t('app', 'Dodaj dokument'), 'url' => '', 'linkOptions' => array('class' => 'btn-warning', 'onclick' => '$("#addAttachment").modal("show");')),
	array('label' => Yii::t('app', 'Save'), 'url' => '', 'linkOptions' => array('class' => 'btn-success', 'onclick' => '$("#download-form").submit();')),
);
	?>


	<div class="alert-placeholder">
		<?php
		$this->widget('booster.widgets.TbAlert', array(
			'fade' => true,
			'closeText' => '&times;', // false equals no close link
			'events' => array(),
			'htmlOptions' => array(),
			'userComponentId' => 'user',
			'alerts' => array( // configurations per alert type
				// success, info, warning, error or danger
				'success' => array('closeText' => '&times;'),
				'info', // you don't need to specify full config
				'warning' => array('closeText' => false),
				'error' => array('closeText' => Yii::t('app','Error')),
			),
		));
		?>

	</div>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>

<div class="col-md-6 col-sm-12 col-md-offset-3">
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>'download-attachment-grid',
    'dataProvider'=>$download_attachment->search(),


    'filter'=>null,
    'columns'=>array(

        'title',
        'filename',


        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\"glyphicon glyphicon-file\"></i>",Yii::app()->createUrl("/download/downloadFile/".$data->id))',
        ),
        array(
            'htmlOptions' => array('nowrap'=>'nowrap'),
            'template' => '{delete}',
            'class'=>'booster.widgets.TbButtonColumn',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('app','Update'),
                    'options' => array(
                        'class' => 'btn btn-xs update'
                    )
                ),
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/download/deleteFile/".$data->id)',
                    'label' => Yii::t('app','Delete'),
                    'options' => array(
                        'class' => 'btn btn-xs delete'
                    ),

                )
            ),
        ),
    ),
)); ?>


</div>
<?php
/************* IMPORT *******************/

$this->beginWidget('booster.widgets.TbModal', array(
	'id' => "addAttachment",
	'fade' => false,
	'options' => array('size' => 'large')
));
?>

<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4 id="modal-title1"><?php echo Yii::t('app', 'Dodaj dokument'); ?></h4>
</div>
<div class="modal-body">
	<?php $this->renderPartial("_attachment", array('model' => $model)); ?>
</div>

<?php $this->endWidget(); ?>
