<?php
$this->breadcrumbs = array(
	Yii::t('app', 'Articles') => array('index'),
	$model->title => array('update', 'id' => $model->id),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List'), 'url' => array('index'), 'linkOptions' => array('class' => 'btn-primary')),

);
?>
<div class="alert-placeholder">
	<?php
	$this->widget('booster.widgets.TbAlert', array(
		'fade' => true,
		'closeText' => '&times;', // false equals no close link
		'events' => array(),
		'htmlOptions' => array(),
		'userComponentId' => 'user',
		'alerts' => array( // configurations per alert type
			// success, info, warning, error or danger
			'success' => array('closeText' => '&times;'),
			'info', // you don't need to specify full config
			'warning' => array('closeText' => false),
			'error' => array('closeText' => Yii::t('app', 'Error')),
		),
	));
	?>
</div>
<div class="row">
	<div class="col-md-4">
		<?php
		$this->widget(
			'booster.widgets.TbTabs', array(
				'type' => 'tabs', // 'tabs' or 'pills'
				'tabs' => $tabs,
			)
		);
		?>
	</div>

	<div class="col-md-8">

		<?php echo $this->renderPartial('_gallery_images', array('model' => $model)); ?>


	</div>
</div>
<script>
	$(document).ready(function () {
		Dropzone.autoDiscover = false;

		$('.sortable').sortable({});

	});

	$('#file-dropzone').dropzone({
		url: '<?=Yii::app()->createUrl("gallery/uploadImage");?>',
		addRemoveLinks: true,
		autoDiscover: false,
		maxFilesize: 100,

		paramName: "uploadfile",
		maxThumbnailFilesize: 99999,
		previewsContainer: '.visualizacao',
		previewTemplate: $('.preview').html(),
		init: function () {
			this.on('success', function (file, json) {
				let n = JSON.parse(json);
				file.previewElement.querySelector("img").alt = n.filename;
			});

			this.on('addedfile', function (file) {

			});

			this.on('sending', function (file, xhr, formData) {
				let article = '<?= $model->id;?>';
				formData.append('gallery_id', article);
			});


			this.on('drop', function (file) {
				console.log('File', file)
			});
		}
	});

	$('#gallery-form').on('submit', function (e) {
		// e.preventDefault();
		let listElements = $('.sortable').children();
		console.log(listElements);
		if (listElements.length > 0) {
			let firstImage = listElements[0].childNodes[1].firstElementChild.firstElementChild.alt;
			$(this).append('<input type="hidden" value="' + firstImage + '" name="ImageFirst">');
			let images = '';
			listElements.each(function (index, element) {
				if (index > 0) {
					images += '<input type="hidden" value="' + element.childNodes[1].firstElementChild.firstElementChild.alt + '" name="Image[]">';
				}
			});
			$(this).append(images);
		}


	});

</script>
