


<h4><?= Yii::t('app','Images');?></h4>


<div class="dropzone" drop-zone="" id="file-dropzone"></div>
<div class="alert-placeholder"></div>
<ul class="visualizacao sortable dropzone-previews">
    <?php
    $gallery_images = GalleryImage::model()->findAll(array('condition'=>'gallery_id='.$model->id,'order'=>'priority ASC'));
    ?>

    <?php foreach ($gallery_images as $image): ?>
        <li>
            <div>
                <div class="dz-preview dz-file-preview">
                    <?= CHtml::image(Yii::app()->request->baseUrl.$image->filepath, $image->filename,array('class' => 'img-responsive')); ?>
                </div>
            </div>
            <a class="dz-remove" href="javascript:undefined" data-dz-remove="<?=$image->id;?>"><?=Yii::t('app','Remove file');?></a>
        </li>
    <?php endforeach; ?>

</ul>
<div class="preview" style="display:none;">
    <li>
        <div>
            <div class="dz-preview dz-file-preview">
                <img data-dz-thumbnail/>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <!--
                <div class="dz-success-mark"><span>✔</span></div>
                <div class="dz-error-mark"><span>✘</span></div>
                -->
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
            </div>
        </div>
    </li>
</div>

<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => "imagePreview",
    'fade' => false,
    'options' => array('size' => 'large')
));
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 id="modal-title"></h4>
</div>
<div class="modal-body" id="modal-body">

</div>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function(){

        var modal = $('#imagePreview').children()[0];

         modal.style.width = '800px';

        $('.dz-remove').on('click',function(){
            if (!confirm('<?=Yii::t("app","Are you sure you want to delete this item?");?>')) {
                return false;
            }
            let id = $(this).data('dz-remove');
            let li = $(this).parent();
            console.log(li);
            $.ajax({
                url: '<?=Yii::app()->createUrl('gallery/removeImage');?>' + '/' + id,
                type: 'post',
                success: function(data)
                {
                    if (data=='OK') {

                        li.remove();
                    }
                }
            })

        });

        $('img').on('dblclick',function(){
            let image = $(this);

            $('#modal-title').html(image.prop('src'));
            let img = '<img src="'+image.prop('src')+'" class="img-responsive">';
            console.log(img);
            $('#modal-body').html(img);
            $('#imagePreview').modal('show');
        });

    });

</script>