<?php

class SettingsController extends Controller {

    public $breadcrumbs;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index','uploadImage'),
                'roles' => array('superadministrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex()
    {
        $logo = '/media/logo.png';
        $model = SiteSeo::model()->findByPk(1);

        if (isset($_POST['SiteSeo'])) {
            $model->attributes = $_POST['SiteSeo'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success',Yii::t('app','Saved'));
            }
        }
        $this->render('index',array('logo' => $logo,'model'=>$model));
    }
    
    public function actionUploadImage() {
        if (Yii::app()->request->isPostRequest) {
            $file = CUploadedFile::getInstanceByName('file');

            if ($file) {
                $filepath = $_SERVER['DOCUMENT_ROOT'].'/media/logo.png';

                if ($file->saveAs($filepath)) {

                    echo $filepath;
                } else {
                    Yii::app()->user->setFlash('error', 'Image could not be saved');
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


}
