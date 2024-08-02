<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Settings') => array('index'),
    Yii::t('app', 'List'),
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
<?php $this->renderPartial('_form',array('model'=>$model));?>
