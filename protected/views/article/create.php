<?php
$this->breadcrumbs=array(
	Yii::t('app','Vesti')=>array('index'),
	Yii::t('app','Create'),
);

$this->menu=array(
array('label'=>Yii::t('app','List'),'url'=>array('index'),'linkOptions'=>array('class'=>'btn-primary')),


);
?>


<div class="row">
    <div class="col-md-8">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>