<?php

class GalleryController extends Controller {

    public $breadcrumbs;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'uploadImage', 'removeImage'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Gallery;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Gallery created. Upload some images.'));
                $this->redirect(array('update', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Gallery'])) {

            $model->attributes = $_POST['Gallery'];
            if ($model->save()) {
                if (isset($_POST['ImageFirst'])) {
                    $image = GalleryImage::model()->findByAttributes(array('filename' => $_POST['ImageFirst'], 'gallery_id' => $model->id));
                    if ($image) {
                        $image->priority = 0;
                        $image->save();
                    }
                }
                if (isset($_POST['Image'])) {
                    $priority = 1;
                    foreach ($_POST['Image'] as $posted_image) {
                        $image = GalleryImage::model()->findByAttributes(array('filename' => $posted_image, 'gallery_id' => $model->id));
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();
            Yii::app()->Helpers->rrmdir(Yii::app()->basePath . "/../media/galleries/" . $id);
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Gallery('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Gallery']))
            $model->attributes = $_GET['Gallery'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Gallery::model()->multilingual()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gallery-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionRemoveImage($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $image = GalleryImage::model()->findByPk($id);
            $filepath = $_SERVER['DOCUMENT_ROOT'] . $image->filepath;

            if ($image && $image->delete()) {
                if (is_file($filepath)) {
                    unlink($filepath);

                }
                echo 'OK';
            }

        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUploadImage()
    {
        if (Yii::app()->request->isPostRequest) {
            $file = CUploadedFile::getInstanceByName('uploadfile');
            $filename = $file->name;


            if ($file) {
                $folder = Yii::app()->basePath . '/../media/galleries/'. $_POST['gallery_id'];


                if (!is_dir($folder)) {
                    mkdir($folder);
                }


                if ($file->saveAs($folder . '/' . $filename)) {
                    $filepath = '/media/galleries/' . $_POST['gallery_id'] . '/' . $filename;

                    $gallery_image = new GalleryImage;
                    $gallery_image->attributes = array(
                        'gallery_id' => $_POST['gallery_id'],

                        'filename' => $filename,
                        'filepath' => $filepath,

                    );
                    if ($gallery_image->save()) {
                        echo json_encode(array('filename' => $gallery_image->filename));
                    } else {
                        echo json_encode(array('error' => CHtml::errorSummary($gallery_image)));
                    }
                } else {
                    echo json_encode(array('error' => 'error'));
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');

    }

    public function resizeImage($file) {
        $maxWidth = Yii::app()->params['gallery']['imageWidth'];
        $imageSize = getimagesize($file);
        if ($imageSize[0] > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = ($imageSize[1] * $maxWidth) / $imageSize[0];
            $this->resize($file, $newWidth, $newHeight, $file, 255, 255, 255);
            return true;
        }
    }

    public function makeImageThumb($file) {
        $thumbWidth = 350; //thumbnail width za Galeriju
        $thumbHeight = 219; //thumbnail height za Galeriju 
        $imageSize = getimagesize($file);
        $filePathInfo = pathinfo($file);
        $dirName = $filePathInfo['dirname'];
        $fileName = $filePathInfo['basename'];
        $newWidth = $thumbWidth;
        $newHeight = $thumbHeight;
        $this->resize($file, $newWidth, $newHeight, $dirName . "/thumb/" . $fileName, 255, 255, 255);
        return true;
    }

    public function getImageProperties($file) {
        $imageSize = getimagesize($file);
        return array('width' => $imageSize[0], 'height' => $imageSize[1], 'filesize' => filesize($file));
    }

    public function resize($url, $box_w, $box_h, $savePath, $r, $g, $b) {
        $background = ImageCreateTrueColor($box_w, $box_h);
        $color = imagecolorallocate($background, $r, $g, $b);
        imagefill($background, 0, 0, $color);
        $image = $this->openImage($url, $r, $g, $b);
        if ($image === false) {
            die('Unable to open image');
        }
        $w = imagesx($image);
        $h = imagesy($image);
        $ratio = $w / $h;
        $target_ratio = $box_w / $box_h;
        if ($ratio < $target_ratio) {
            $new_w = $box_w;
            $new_h = round($box_w / $ratio);
            $x_offset = 0;
            $y_offset = round(($box_h - $new_h) / 2);
        } else {
            $new_h = $box_h;
            $new_w = round($box_h * $ratio);
            $x_offset = round(($box_w - $new_w) / 2);
            $y_offset = 0;
        }
        $insert = ImageCreateTrueColor($new_w, $new_h);
        imagecopyResampled($insert, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        imagecopymerge($background, $insert, $x_offset, $y_offset, 0, 0, $new_w, $new_h, 100);
        imagejpeg($background, $savePath, 80);
        imagedestroy($insert);
        imagedestroy($background);
    }

    public function openImage($file, $r = '255', $g = '255', $b = '255') {
        $size = getimagesize($file);

        switch ($size["mime"]) {
            case "image/jpeg":
                $fh = fopen($file, 'rb');
                $str = '';
                while ($fh !== false && !feof($fh)) {
                    $str .= fread($fh, 1024);
                }
                //$im = imagecreatefromjpeg($file); //jpeg file
                $im = imagecreatefromstring($str); //jpeg file
                break;
            case "image/gif":
                $im = imagecreatefromgif($file); //gif file
                imageAlphaBlending($im, false);
                imageSaveAlpha($im, true);
                $background = imagecolorallocate($im, 0, 0, 0);
                imagecolortransparent($im, $background);

                $color = imagecolorallocate($im, $r, $g, $b);
                for ($i = 0; $i < imagesy($im); $i++) {
                    for ($j = 0; $j < imagesx($im); $j++) {
                        $rgb = imagecolorat($im, $j, $i);
                        if ($rgb == 2) {
                            imagesetpixel($im, $j, $i, $color);
                        }
                    }
                }

                break;
            case "image/png":
                $im = imagecreatefrompng($file); //png file
                $background = imagecolorallocate($im, 0, 0, 0);
                imageAlphaBlending($im, false);
                imageSaveAlpha($im, true);
                imagecolortransparent($im, $background);
                $color = imagecolorallocate($im, $r, $g, $b);
                for ($i = 0; $i < imagesy($im); $i++) {
                    for ($j = 0; $j < imagesx($im); $j++) {
                        $rgb = imagecolorat($im, $j, $i);
                        if ($rgb == 2) {
                            imagesetpixel($im, $j, $i, $color);
                        }
                    }
                }

                break;
            default:
                $im = false;
                break;
        }
        return $im;
    }

}
