<?php
$this->breadcrumbs=array(
	Yii::t('app','Galleries')=>array('index'),
	Yii::t('app','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','List'),'url'=>array('index'),'linkOptions'=>array('class'=>'btn-primary')),


);
?>


<div class="row">
	<div class="col-md-4">
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>