<?php
$this->breadcrumbs=array(
	Yii::t('app','Article Categories')=>array('index'),
	Yii::t('app','Create'),
);

$this->menu=array(
array('label'=>Yii::t('app','List'),'url'=>array('index'),'linkOptions'=>array('class'=>'btn-primary')),

);
?>

<div class="clearfix"></div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

