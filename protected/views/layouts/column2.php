<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <!-- WRAPPER -->
    <div id="wrapper">

        <!--
                ASIDE
                Keep it outside of #wrapper (responsive purpose)
        -->
        <aside id="aside">
            <!--
                    Always open:
                    <li class="active alays-open">

                    LABELS:
                            <span class="label label-danger pull-right">1</span>
                            <span class="label label-default pull-right">1</span>
                            <span class="label label-warning pull-right">1</span>
                            <span class="label label-success pull-right">1</span>
                            <span class="label label-info pull-right">1</span>
            -->
            <nav id="sideNav"><!-- MAIN MENU -->
                <ul class="nav nav-list">


                    <li<?php echo ($this->getId() == 'claim') ? ' class="active"' : ''; ?>>
                        <a href="<?php echo Yii::app()->createUrl('page'); ?>">

                            <i class="main-icon fa fa-list"></i>
                            <span><?php echo Yii::t('app', 'Pages'); ?></span>
                        </a>

                    </li>

                    <li>
                        <a href="#">
                            <i class="fa fa-menu-arrow pull-right"></i>
                            <i class="main-icon fa fa-key"></i>
                            <span><?php echo Yii::t('app', 'Articles'); ?></span>
                        </a>
                        <ul>
                            <li<?php echo ($this->getId() == 'articleCategory') ? ' class="active"' : ''; ?>>
                                <a href="<?php echo Yii::app()->createUrl('articleCategory'); ?>">

                                    <span><?php echo Yii::t('app', 'Article Categories'); ?></span>
                                </a>

                            </li>

                            <li<?php echo ($this->getId() == 'articleGroup') ? ' class="active"' : ''; ?>>
                                <a href="<?php echo Yii::app()->createUrl('articleGroup'); ?>">

                                    <span><?php echo Yii::t('app', 'Article Groups'); ?></span>
                                </a>

                            </li>

                            <li<?php echo ($this->getId() == 'article') ? ' class="active"' : ''; ?>>
                                <a href="<?php echo Yii::app()->createUrl('article'); ?>">

                                    <span><?php echo Yii::t('app', 'Articles'); ?></span>
                                </a>

                            </li>


                        </ul>
                    </li>
                    <li<?php echo ($this->getId() == 'gallery') ? ' class="active"' : ''; ?>>
                        <a href="<?php echo Yii::app()->createUrl('gallery'); ?>">

                            <i class="main-icon fa fa-image"></i>
                            <span><?php echo Yii::t('app', 'Galleries'); ?></span>
                        </a>

                    </li>

                    <li<?php echo ($this->getId() == 'menu') ? ' class="active"' : ''; ?>>
                        <a href="<?php echo Yii::app()->createUrl('menu'); ?>">

                            <i class="main-icon fa fa-list-alt"></i>
                            <span><?php echo Yii::t('app', 'Menu'); ?></span>
                        </a>

                    </li>


                    <?php if (Yii::app()->user->roles == 'superadministrator'): ?>


                        <li<?php echo ($this->getId() == 'user') ? ' class="active"' : ''; ?>>
                            <a href="<?php echo Yii::app()->createUrl('user'); ?>">

                                <i class="main-icon fa fa-users"></i> <span><?php echo Yii::t('app', 'Users'); ?></span>
                            </a>

                        </li>
                        <li<?php echo ($this->getId() == 'language') ? ' class="active"' : ''; ?>>
                            <a href="<?php echo Yii::app()->createUrl('language'); ?>">

                                <i class="main-icon fa fa-language"></i>
                                <span><?php echo Yii::t('app', 'Languages'); ?></span>
                            </a>

                        </li>
                    <?php endif; ?>
                </ul>


            </nav>

            <span id="asidebg"><!-- aside fixed background --></span>
        </aside>
        <!-- /ASIDE -->


        <!-- HEADER -->
        <header id="header">

            <!-- Mobile Button -->
            <button id="mobileMenuBtn"></button>

            <!-- Logo -->
            <span class="logo pull-left">
            <h1 style="color:#fff !important">CCMS</h1>
        </span>


            <div class="nav-collapse">

                <!-- OPTIONS LIST -->
                <ul class="nav pull-right">
                    <?php if (Yii::app()->language == 'sr_yu'): ?>
                        <li class="pull-right" style="margin-top:5px;margin-right:5px;"><!-- lockscreen -->
                            <a href="?_lang=en">EN</a>
                        </li>
                    <?php else: ?>
                        <li class="pull-right" style="margin-top:5px;margin-right:5px;"><!-- lockscreen -->
                            <a href="?_lang=sr_yu">RS</a>
                        </li>
                    <?php endif; ?>
                    <!-- USER OPTIONS -->
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img class="user-avatar" alt="" src="<?php
                            echo Yii::app()->baseUrl;;
                            ?>/images/noavatar.jpg" height="34"/>
                            <span class="user-name">
                            <span class="hidden-xs">
                                <?php echo Yii::app()->user->name; ?> <i class="fa fa-angle-down"></i>
                            </span>
                        </span>
                        </a>
                        <ul class="dropdown-menu hold-on-click">

                            <li><!-- lockscreen -->
                                <a href="<?php echo Yii::app()->createUrl('user/passwordself'); ?>"><i
                                            class="fa fa-lock"></i> <?php echo Yii::t('app', 'Change Password'); ?></a>
                            </li>
                            <li><!-- logout -->
                                <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><i
                                            class="fa fa-power-off"></i> <?php echo Yii::t('app', 'Log Out'); ?></a>
                            </li>
                        </ul>
                    <li class="pull-right" style="margin-top:8px;margin-right:5px;">
                        <div id="screen-time"><?= date("H:i"); ?></div>
                    </li>
                    </li>
                    <!-- /USER OPTIONS -->

                </ul>
                <!-- /OPTIONS LIST -->

            </div>

        </header>
        <!-- /HEADER -->

        <!-- Include content pages -->
        <section id="middle">

            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'homeLink' => CHtml::link(Yii::t('app', 'Dashboard'), Yii::app()->createUrl('/')),
                    'htmlOptions' => array('class' => 'breadcrumb')
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php
            $this->widget('booster.widgets.TbMenu', array(
                /* 'type'=>'list', */
                //'encodeLabel'=>false,
                'type' => 'pills',
                'items' => $this->menu,
                'lastItemCssClass' => 'float-right',
            ));
            ?>
            <?php echo $content; ?>
        </section>
    </div><!--/WRAPPER-->


<?php $this->endContent(); ?>