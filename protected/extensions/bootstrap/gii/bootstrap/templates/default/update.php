<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('app','Izmeni'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app','Lista ') . '<?php echo $this->modelClass; ?>', 'url'=>array('index')),
	array('label'=>Yii::t('app','Kreiraj ') . '<?php echo $this->modelClass; ?>', 'url'=>array('create')),
	array('label'=>Yii::t('app','Pregledaj ') . '<?php echo $this->modelClass; ?>', 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('app','Upravljaj ') . '<?php echo $this->modelClass; ?>', 'url'=>array('admin')),
);
?>

    <h1>Update <?php echo $this->modelClass . " <?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>