
<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Users') => array('index'),
    Yii::t('app', 'List'),
);

$this->menu = array(
    

   // array('label' => Yii::t('app', 'Create'), 'url' => array('create'),'linkOptions'=>array('class'=>'btn-primary')),
);
?>

<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '{summary}{items}{pager}',
    'summaryText' => Yii::t('app', 'Showing {start} - {end} of {count}'),
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'nextPageLabel' => Yii::t('app', "Next"), 'prevPageLabel' => Yii::t('app', 'Previous')),
    'columns' => array(
        'name',
        'email',
       
        array(
            'name' => 'roles',
            'type' => 'raw',
            'value' => 'ucfirst($data->roles)',
            'filter' => CHtml::listData(array(array('id' => 'administrator', 'title' => Yii::t('app', 'Administrator')),array('id' => 'company', 'title' => Yii::t('app', 'Company')),array('id' => 'candidate', 'title' => Yii::t('app', 'Candidate'))), 'id', 'title'),
        ),
        array(
            'name' => 'active',
            'type' => 'raw',
            'filter' => CHtml::listData(array(array('id' => 0, 'title' => Yii::t('app', 'No')), array('id' => 1, 'title' => Yii::t('app', 'Yes'))), 'id', 'title'),
            'value' => '($data->active) ? "<span class=\"glyphicon glyphicon-ok\"></span>" : "<span class=\"glyphicon glyphicon-remove\"></span>"',
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
                    'visible' => (Yii::app()->params['adminDelete']),
                )
            ),
        ),
    ),
));
?>
