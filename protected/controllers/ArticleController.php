<?php

class ArticleController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'create', 'update', 'delete', 'uploadImage', 'removeImage'),
                'roles' => array('administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Article::model()->multilingual()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Article;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Created'));
                $this->redirect(array('update', 'id' => $model->id));
            }
        }


        $this->render('create', array(
            'model' => $model,

        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($this->appUser->roles != "superadministrator" && $model->created_user_id != $this->appUser->id) {
            throw new CHttpException('404','Vest nije pronadjena.');
        }

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Article'])) {

            $model->attributes = $_POST['Article'];
            if ($model->save()) {

                if (isset($_POST['ImageFirst'])) {
                    $image = ArticleGallery::model()->findByAttributes(array('filename' => $_POST['ImageFirst'], 'article_id' => $model->id));
                    if ($image) {
                        $image->priority = 0;
                        $image->save();
                    }
                }
                if (isset($_POST['Image'])) {
                    $priority = 1;
                    foreach ($_POST['Image'] as $posted_image) {
                        $image = ArticleGallery::model()->findByAttributes(array('filename' => $posted_image, 'article_id' => $model->id));
                        if ($image) {
                            $image->priority = $priority;
                            $image->save();
                        }
                        $priority++;
                    }
                }


                Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
            }
        }


        $tabs = array(
            array(
                'label' => Yii::t('app', 'Update'),
                'content' => $this->renderPartial('_form', array('model' => $model), true),
                'active' => isset($_POST['Language']) ? false : true,
            )
        );

        $tabs_counter = 1;

        if (isset($_POST['Language'])) {
            foreach ($_POST['Language'] as $l => $v) {

                $lang_tab = trim($l, '_');
            }
        } else {
            $lang_tab = 'sr_yu';
        }

        foreach (Language::model()->findAll() as $language) {


            $tabs[] = array(
                'label' => $language->title,
                'content' => $this->renderPartial('_form_lang', array('model' => $model, 'lang' => '_' . $language->lang), true),
                'active' => $lang_tab == $language->lang ? true : false,
            );
            $tabs_counter++;
        }


        $this->render('update', array(
            'model' => $model,
            'tabs' => $tabs,
        ));
    }

    public function actionRemoveImage($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $image = ArticleGallery::model()->findByPk($id);
            $filepath = Yii::app()->basePath . '/..' . $image->filepath;

            if ($image && $image->delete()) {
                if (is_file($filepath)) {
                    unlink($filepath);

                }
                echo 'OK';
            }

        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Article('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Article'])) {
            $model->attributes = $_GET['Article'];
        }
        $model->created_user_id = $this->appUser->id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionUploadImage()
    {
        if (Yii::app()->request->isPostRequest) {
            $file = CUploadedFile::getInstanceByName('uploadfile');
            $filename = $file->name;


            if ($file) {
                $folder = Yii::app()->basePath . '/../media/articles/' . $_POST['article_id'];

                if (!is_dir($folder)) {
                    mkdir($folder);
                }


                if ($file->saveAs($folder . '/' . $filename)) {
                    $filepath = '/media/articles/' . $_POST['article_id'] . '/' . $filename;

                    $article_gallery = new ArticleGallery;
                    $article_gallery->attributes = array(
                        'article_id' => $_POST['article_id'],

                        'filename' => $filename,
                        'filepath' => $filepath,

                    );
                    if ($article_gallery->save()) {
                        echo json_encode(array('filename' => $article_gallery->filename));
                    } else {
                        echo json_encode(array('error' => CHtml::errorSummary($article_gallery)));
                    }
                } else {
                    echo json_encode(array('error' => 'error'));
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');

    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'article-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
