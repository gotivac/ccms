<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Downloads') => array('index'),
    Yii::t('app', 'List'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List'), 'url' => array('index'), 'linkOptions' => array('class' => 'btn-primary')),
    array('label' => Yii::t('app', 'Create'), 'url' => array('create'), 'linkOptions' => array('class' => 'btn-success')),
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
            'error' => array('closeText' => Yii::t('app', 'Error')),
        ),
    ));
    ?>
</div>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id' => 'download-grid',
    'dataProvider' => $model->search(),
    'summaryText' => Yii::t('app', 'Showing {start} - {end} of {count}'),
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'nextPageLabel' => Yii::t('app', "Next"), 'prevPageLabel' => Yii::t('app', 'Previous')),
    'filter' => $model,
    'columns' => array(

        'title',
        array(
            'name' => 'description',
            'value' => 'nl2br($data->description)',
            'htmlOptions' => array('class'=>'col-md-6')
        ),
        array(
            'name' => 'active',
            'type' => 'raw',
            'filter' => CHtml::listData(array(array('id' => 0, 'title' => Yii::t('app', 'No')), array('id' => 1, 'title' => Yii::t('app', 'Yes'))), 'id', 'title'),
            'value' => '($data->active) ? "<span class=\"glyphicon glyphicon-ok\"></span>" : "<span class=\"glyphicon glyphicon-remove\"></span>"',
            'htmlOptions' => array('class' => 'text-center col-lg-1'),
        ),
        'slug',
        array(
            'header' => '',
            'value' => '$data->createdUser->token',
        ),
        array(
            'htmlOptions' => array('nowrap' => 'nowrap'),
            'template' => '{update} {delete}',
            'class' => 'booster.widgets.TbButtonColumn',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('app', 'Update'),
                    'options' => array(
                        'class' => 'btn btn-xs update'
                    )
                ),
                'delete' => array(
                    'label' => Yii::t('app', 'Delete'),
                    'options' => array(
                        'class' => 'btn btn-xs delete'
                    ),

                )
            ),
        ),
    ),
)); ?>
