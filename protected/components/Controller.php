<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    public $appUser = false;

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    

    protected function download($file) {
        $file = Yii::app()->basePath .'/../'. $file;
        if (file_exists($file)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);

            exit;
        } else {

            echo "Error exporting document: " . $file;
        }
    }

    public function init()
    {
        parent::init();
        if (!Yii::app()->user->isGuest) {
            $this->appUser = User::model()->findByPk(Yii::app()->user->id);
        }
        $app = Yii::app();
        if (isset($_GET['_lang']))
        {
            $app->language = $_GET['_lang'];
            $app->session['_lang'] = $app->language;
        }
        else if (isset($app->session['_lang']))
        {
            $app->language = $app->session['_lang'];
        } else {
            $app->language = 'sr_yu';
        }


    }

}
