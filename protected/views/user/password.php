<?php
/* @var $this UserController */
/* @var $model User */
   
    $this->breadcrumbs = array(
        Yii::t('app', 'Change Password'),
    );
$this->menu = array(
    array('label' => Yii::app()->user->name, 'url' => '','linkOptions'=>array('class'=>'btn-primary')),
    array('label' => Yii::t('app', 'Change Password'), 'url' => array('passwordself'),'active' => true,'linkOptions'=>array('class'=>'btn-primary')),
);


?>

<?php $this->widget('booster.widgets.TbAlert', array(
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
));?>
<?php $this->renderPartial('_password', array());?>