<?php

class ArticleCategoryController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete'),
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
        $model = ArticleCategory::model()->multilingual()->findByPk($id);
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
        $model = new ArticleCategory;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['ArticleCategory'])) {
            $model->attributes = $_POST['ArticleCategory'];
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

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['ArticleCategory'])) {
            $model->attributes = $_POST['ArticleCategory'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
            }

        }
        $tabs = array(
            array(
                'label' => Yii::t('app', 'Update'),
                'content' => $this->renderPartial('_form', array('model' => $model), true),
                'active' => ((!isset($_GET['tab'])) || (isset($_GET['tab']) && $_GET['tab'] == 0)) ? true : false,
            )
        );

        $tabs_counter = 1;

        foreach (Language::model()->findAll() as $language) {
            $tabs[] =  array(
                'label' => $language->title,
                'content' => $this->renderPartial('_form_lang',array('model'=>$model,'lang'=>'_'.$language->lang),true),
                'active' => isset($_GET['tab']) && $_GET['tab'] == $tabs_counter ? true : false,
            );
            $tabs_counter++;
        }

        $this->render('update', array(
            'model' => $model,
            'tabs' => $tabs,
        ));
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
        $model = new ArticleCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArticleCategory']))
            $model->attributes = $_GET['ArticleCategory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'article-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
