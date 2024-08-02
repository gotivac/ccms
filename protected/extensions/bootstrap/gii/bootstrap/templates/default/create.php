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
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	Yii::t('app','Kreiraj'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app','Lista ') . '<?php echo $this->modelClass; ?>', 'url'=>array('index')),
	array('label'=>Yii::t('app','Upravljaj ') . '<?php echo $this->modelClass; ?>', 'url'=>array('admin')),
);
?>

<h1>Create <?php echo $this->modelClass; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>