<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Article Categories') => array('index'),
    Yii::t('app', 'List'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create'), 'url' => array('create')),
);

?>


<?php $this->widget('booster.widgets.TbGridView', array(
    'id' => 'article-category-grid',
    'dataProvider' => $model->search(),
    'summaryText' => Yii::t('app', 'Showing {start} - {end} of {count}'),

    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('class' => 'text-right col-md-1')
        ),

        array(
            'name' => 'parent_id',
            'filter' => CHtml::listData(ArticleCategory::model()->findAll(),'id','title'),
            'value' => '$data->parent ? $data->parent->title : ""'
        ),

        'title',
        'slug',

        array(
            'header' => Yii::t('app','Created'),
            'type' => 'raw',
            'value' => 'date("d.m.Y H:i:s", strtotime($data->created_dt)) . "<br>" . $data->createdUser->name',
            'htmlOptions' => array('class' => 'text-center col-lg-1'),
        ),

        array(
            'header' => Yii::t('app','Updated'),
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
