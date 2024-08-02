<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
echo "\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	Yii::t('app','Upravljaj'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app','Lista ') . '<?php echo $this->modelClass; ?>', 'url'=>array('index')),
	array('label'=>Yii::t('app','Kreiraj ') . '<?php echo $this->modelClass; ?>', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo "<?php echo Yii::t('app','Upravljaj');?>"?> <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<p><?php echo "<?php echo Yii::t('app', 'Možete koristiti simbole za poređenje (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) na početku svake vrednosti za pretragu da biste definisali kako će se pretraga ponašati.');?>";?></p>


<?php echo "<?php echo CHtml::link(Yii::t('app','Napredna pretraga'),'#',array('class'=>'search-button btn')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
    if (++$count == 7) {
		echo "\t\t/*\n";
	}
    echo "\t\t'" . $column->name . "',\n";
}
if ($count >= 7) {
	echo "\t\t*/\n";
}
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>