<?php
$this->breadcrumbs=array(
	Yii::t('app','Menus')=>array('index'),
	Yii::t('app','Create'),
);

$this->menu=array(
    array('label' => Yii::t('app', 'List'), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create'), 'url' => array('create'), 'active' => true),
    array('label' => Yii::t('app', 'Menu tree'), 'url' => array('tree')),
);
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>