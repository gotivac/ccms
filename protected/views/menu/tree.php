<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Menus') => array('index'),
    Yii::t('app', 'Tree'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List'), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create'), 'url' => array('create')),
    array('label' => Yii::t('app', 'Menu tree'), 'url' => array('tree'), 'active' => true),
);
?>


<?php

echo $this->widget('CTreeView', array('data' => $tree), true);
?>