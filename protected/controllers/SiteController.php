<?php

class SiteController extends CController {

    public $layout = '//layouts/column1';
    public $menu = array();
    public $breadcrumbs = array();
    public $side_menu = array();

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionAuthenticate() {
        $user = User::model()->findByPk(Yii::app()->user->id);

        if (isset($_POST['code'])) {

            if ($user->code == $_POST['code']) {

                Yii::app()->session['authenticated'] = true;
                Yii::app()->user->setFlash('success', Yii::t('app', 'Welcome'));
                $this->redirect('index');
            } else {
                Yii::app()->user->setFlash('error', Yii::t('app', 'Incorrect code'));
            }
        } else {
            $mail = new YiiMailer();
            $mail->setFrom('no-reply@otwd.com.au', 'WTC');
            $mail->setTo($user->email);
            $mail->setSubject('Code');
            $mail->setBody($user->code);
            $mail->send();
        }






        $this->render('auth', array());
    }

    public function actionIndex() {

        $this->layout = '//layouts/column2';

        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = '//layouts/column2';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;
        $user = new User;

        $visible = 'login';

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->rememberMe == 'on') {
                $model->rememberMe = 1;
            } else {
                $model->rememberMe = 0;
            }

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {

                $_SESSION['KCFINDER'] = array();
                $_SESSION['KCFINDER']['disabled'] = false;
                $this->redirect(Yii::app()->baseUrl);
            }
        }



        // display the login form
        $this->render('login', array('model' => $model, 'user' => $user, 'visible' => $visible));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();

        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionSlug() {
        if (isset($_POST['title']) AND $_POST['title'] != "") {
            echo Yii::app()->Helpers->url_slug($_POST['title']);
        } else {
            echo '';
        }
    }

    public function actionFeeds() {
        $this->layout = '//layouts/column2';
        $feeds = scandir($_SERVER['DOCUMENT_ROOT'] . '/xmlfeed');
        
        if (($key = array_search('.', $feeds)) !== false) {
            unset($feeds[$key]);
        }
        if (($key = array_search('..', $feeds)) !== false) {
            unset($feeds[$key]);
        }
         
        if (($key = array_search('_classes', $feeds)) !== false) {
            unset($feeds[$key]);
        }
        $this->render('feeds',array('model' => $feeds));
    }

}
