<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Article Groups') => array('index'),
    Yii::t('app', 'List'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create'), 'url' => array('create')),
);

?>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id' => 'article-group-grid',
    'dataProvider' => $model->search(),
    'summaryText' => Yii::t('app', 'Showing {start} - {end} of {count}'),
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'nextPageLabel' => Yii::t('app', "Next"), 'prevPageLabel' => Yii::t('app', 'Previous')),
    'filter' => $model,
    'columns' => array(
        'id',
        'title',
        'slug',
        array(
            'header' => Yii::t('app', 'Created'),
            'type' => 'raw',
            'value' => 'date("d.m.Y H:i:s", strtotime($data->created_dt)) . "<br>" . $data->createdUser->name',
            'htmlOptions' => array('class' => 'text-center col-lg-1'),
        ),

        array(
            'header' => Yii::t('app', 'Updated'),
            'type' => 'raw',
            'value' => '$data->updatedUser ? date("d.m.Y H:i:s", strtotime($data->updated_dt)) . "<br>" . $data->updatedUser->name : ""',
            'htmlOptions' => array('class' => 'text-center col-lg-1'),
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
