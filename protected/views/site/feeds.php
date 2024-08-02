<?php
$this->breadcrumbs = array(
);

$this->menu = array(
    array('label' => Yii::t('app', 'XML Feeds'), 'url' => array('site/feeds'), 'active' => true),
    
);
?>
<div class="container">
<?php

foreach($model as $feed) : ?>

    <p><b><?php echo strtoupper($feed);?>:</b><a href="<?php echo Helpers::siteUrl().'/xmlfeed/'.$feed.'/';?>" target="_blank"> <?php echo Helpers::siteUrl().'/xmlfeed/'.$feed.'/';?></a></p>
<?php endforeach; ?>

</div>


