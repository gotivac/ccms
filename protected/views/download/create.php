<?php
$this->breadcrumbs=array(
	Yii::t('app','Downloads')=>array('index'),
	Yii::t('app','Create'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'List'), 'url' => array('index'), 'linkOptions' => array('class' => 'btn-primary')),
	array('label' => Yii::t('app', 'Save'), 'url' => '', 'linkOptions' => array('class' => 'btn-success', 'onclick' => '$("#download-form").submit();')),


);
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>