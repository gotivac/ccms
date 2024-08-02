<?php

class DownloadController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete','deleteFile','downloadFile'),
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
        $model = Download::model()->findByPk($id);
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
        $model = new Download;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Download'])) {
            $model->attributes = $_POST['Download'];
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

        if (isset($_POST['Download'])) {
            $model->attributes = $_POST['Download'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
            }
        }

        if (isset($_POST['DownloadAttachment']))
        {

            $attachment = CUploadedFile::getInstanceByName('attachment');

            if (isset($attachment)) {
                $folder = $_SERVER['DOCUMENT_ROOT'] . '/files';

                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $folder = $folder . '/' . $model->id;
                if (!is_dir($folder)) {
                    mkdir($folder);
                }

                $filepath = '/files/' . $model->id;

                if ($attachment->saveAs($folder . '/' . $attachment->name)) {
                    $download_attachment = new DownloadAttachment;
                    $download_attachment->attributes = array(
                        'download_id' => $model->id,
                        'title' => $_POST['DownloadAttachment']['title'],
                        'filename' => $attachment->name,
                        'filepath' => $filepath . '/'.$attachment->name,
                    );

                    if (!$download_attachment->save()) {
                        Yii::app()->user->setFlash('error',CHtml::errorSummary($download_attachment));
                    } else {
                        Yii::app()->user->setFlash('success', 'Dokument sačuvan.');
                    }

                } else {
                    echo '<pre>';var_dump($folder . '/' . $attachment->name,$attachment);die();
                }
            } else {
                Yii::app()->user->setFlash('error','Dokument je obavezno polje.');
            }


        }

        $download_attachment = new DownloadAttachment('search');
        $download_attachment->unsetAttributes();
        $download_attachment->download_id = $model->id;

        $this->render('update', array(
            'model' => $model,
            'download_attachment' => $download_attachment,
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
        $model = new Download('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Download'])) {
            $model->attributes = $_GET['Download'];
        }
        $model->created_user_id = $this->appUser->id;

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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'download-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDownloadFile($id) {
        $model = DownloadAttachment::model()->findByPk($id);
        $this->download($model->filepath);
    }

    public function actionDeleteFile($id) {
        $model = DownloadAttachment::model()->findByPk($id);
        if ($model) {
            $filepath = $_SERVER['DOCUMENT_ROOT'] . '/' . $model->filepath;
            $download = $this->loadModel($model->download_id);
            if ($model->delete()) {
                if (is_file($filepath))
                    unlink($filepath);
                Yii::app()->user->setFlash('success', Yii::t('app', 'Deleted'));
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
            $this->redirect(array('update', 'id' => $download->id));
            die();
        }
        $this->redirect(array('index'));
    }
}
