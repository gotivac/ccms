<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Galleries'),
);
?>

<?php
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
<?php
$this->widget('booster.widgets.TbGridView', array(

    'id' => 'gallery-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,

    'summaryText' => Yii::t('app', 'Showing {start} - {end} of {count}'),

    'columns' => array(
        'title',
        'slug',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => function ($data) {
                $images = '';
                $i = 0;
                $galleryImages = GalleryImage::model()->findAll(array('condition'=>'gallery_id='.$data->id,'order'=>'priority ASC'));
                foreach ($galleryImages as $image) {
                    $images .= '<div class="col-md-2">' .CHtml::image(Yii::app()->request->baseUrl.$image->filepath,$image->filename,array("class"=>"img-responsive")).'</div>';
                $i++;
                    if ($i >= 6) {
                        break;
                    }
                }
                return $images;
            },
            'htmlOptions' => array('class' => 'col-md-6')
        ),

        array(
            'name' => 'active',
            'type' => 'raw',
            'filter' => CHtml::listData(array(array('id' => 0, 'title' => Yii::t('app', 'No')), array('id' => 1, 'title' => Yii::t('app', 'Yes'))), 'id', 'title'),
            'value' => '($data->active) ? "<span class=\"glyphicon glyphicon-ok\"></span>" : "<span class=\"glyphicon glyphicon-remove\"></span>"',
            'htmlOptions' => array('class' => 'text-center col-lg-1'),
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
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'options' => array(
                        'class' => 'btn btn-xs view'
                    )
                ),
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
                    )
                )
            ),
            'htmlOptions' => array('style' => 'width: 72px'),
        )
    ),
));
?>
