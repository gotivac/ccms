<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Pages') => array('index'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('app', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List'), 'url' => array('index'),'linkOptions'=>array('class'=>'btn-primary')),

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
$this->widget(
    'booster.widgets.TbTabs', array(
        'type' => 'tabs', // 'tabs' or 'pills'
        'tabs' => $tabs,
    )
);
?>
