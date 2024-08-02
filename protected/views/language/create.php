<?php
$this->breadcrumbs=array(
	Yii::t('app','Languages')=>array('index'),
	Yii::t('app','Create'),
);

$this->menu=array(
array('label'=>Yii::t('app','List'),'url'=>array('index'),'linkOptions'=>array('class'=>'btn-primary')),

);
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>