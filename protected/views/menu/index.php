<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Menu') => array('index'),
    Yii::t('app', 'List'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Menu'), 'url' => array('index')),
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
    'alerts' => array(// configurations per alert type
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
    <div class="col-md-3 col-md-offset-1">



        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php echo Yii::t('app', 'Pages'); ?></a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse<?php echo ($in == 1) ? ' in' : ''; ?>">
                    <div class="panel-body"><?php $this->renderPartial('_pages', array('pages' => $pages)); ?></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            <?php echo Yii::t('app', 'Articles'); ?></a></a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse collapse<?php echo ($in == 2) ? ' in' : ''; ?>">
                    <div class="panel-body"><?php $this->renderPartial('_posts', array('posts' => $posts)); ?></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            <?php echo Yii::t('app', 'Article Categories'); ?></a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse collapse<?php echo ($in == 3) ? ' in' : ''; ?>">
                    <div class="panel-body"><?php $this->renderPartial('_post_categories', array('post_categories' => $post_categories)); ?></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                            <?php echo Yii::t('app', 'Custom Links'); ?></a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse collapse<?php echo ($in == 4) ? ' in' : ''; ?>">
                    <div class="panel-body"><?php $this->renderPartial('_custom', array('custom_link' => $custom_link)); ?></div>
                </div>
            </div>
        </div> 

    </div>
    <div class="col-md-1 text-center"><h1>&rightarrow;</h1></div>
    <div class="col-md-6">




        <div class="dd">


            <ol class="dd-list" id="dd-list-app-categories-container">
                <?php foreach ($model as $menuItem): ?>
                    <?php if (!empty($menuItem['children'])): ?>
                        <li class="dd-item" data-id="<?php echo $menuItem['id']; ?>">
                            <div class="dd-handle"><span id="category-item"><?php echo $menuItem['title']; ?></span>
                                <a href="<?php echo $this->createUrl('delete', array('id' => $menuItem['id'])); ?>" class="close close-assoc-file" 
                                   data-dismiss="alert" aria-label="close">&times;</a></div>
                            <ol class="dd-list">
                                <?php foreach ($menuItem['children'] as $child): ?>
                                    <li class="dd-item" data-id="<?php echo $child['id']; ?>">
                                        <div class="dd-handle"><span id="category-item"><?php echo $child['title']; ?></span>
                                            <a href="<?php echo $this->createUrl('delete', array('id' => $child['id'])); ?>" class="close close-assoc-file" 
                                               data-dismiss="alert" aria-label="close">&times;</a></div>

                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </li>
                    <?php else: ?>
                        <li class="dd-item" data-id="<?php echo $menuItem['id']; ?>">
                            <div class="dd-handle"><span id="category-item"><?php echo $menuItem['title']; ?><?php echo ($menuItem['link'] == '#') ? ' #' : ''; ?></span>

                                <a href="<?php echo $this->createUrl('delete', array('id' => $menuItem['id'])); ?>" class="close close-assoc-file" 
                                   data-dismiss="alert" aria-label="close">&times;</a></div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

            </ol>   
        </div>

        <div class="text-right">
            <hr>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'context' => 'primary',
                'label' => Yii::t('app', 'Save'),
                'htmlOptions' => array(
                    'onclick' => 'menuSubmit();'
                )
            ));
            ?>

        </div>
    </div>
    <div class="col-md-3"></div>

</div>
