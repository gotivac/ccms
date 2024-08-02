<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Vesti') => array('index'),
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
    'id' => 'article-grid',
    'dataProvider' => $model->search(),
    'summaryText' => Yii::t('app', 'Showing {start} - {end} of {count}'),
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'nextPageLabel' => Yii::t('app', "Next"), 'prevPageLabel' => Yii::t('app', 'Previous')),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('class' => 'text-right col-md-1')
        ),
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title,Yii::app()->createUrl("article",array("update"=>$data->id)))'
        ),
        'slug',
        array(
            'name' => 'active',
            'type' => 'raw',
            'filter' => CHtml::listData(array(array('id' => 0, 'title' => Yii::t('app', 'No')), array('id' => 1, 'title' => Yii::t('app', 'Yes'))), 'id', 'title'),
            'value' => '($data->active) ? "<span class=\"glyphicon glyphicon-ok\"></span>" : "<span class=\"glyphicon glyphicon-remove\"></span>"',
            'htmlOptions' => array('class' => 'text-center col-lg-1'),
        ),
        array(
            'header'=>Yii::t('app','Image'),
            'type' => 'raw',
            'value' =>'$data->image ? CHtml::image(Yii::app()->baseUrl.$data->image->filepath,$data->image->filename,array("class"=>"img-responsive")): ""',
            'htmlOptions' => array('class'=>'col-md-1')
        ),


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
