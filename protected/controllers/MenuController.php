<?php

class MenuController extends Controller
{

    public $breadcrumbs;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column2';

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
                'actions' => array('index', 'tree', 'create', 'update', 'admin', 'delete',),
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Menu;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->link == "" or $model->link == "#")
                $model->link = htmlentities("#");
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
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
    public function actionUpdate()
    {
        $menuItems = json_decode($_POST['menuitems'], true);

        $id = 1;
        $menu = array();
        foreach ($menuItems as $item) {
            $menuItem = Menu::model()->findByPk($item['id']);
            $menu[] = array('id' => $id, 'parent_id' => 0, 'title' => $menuItem->title, 'link' => $menuItem->link);
            if (isset($item['children'])) {
                $i = $id + 1;
                foreach ($item['children'] as $child) {
                    $menuItem = Menu::model()->findByPk($child['id']);
                    $menu[] = array(
                        'id' => $i,
                        'parent_id' => $id,
                        'title' => $menuItem->title,
                        'link' => $menuItem->link
                    );
                    $i++;
                }
                $id = $i;
            } else {
                $id++;
            }
        }


        Yii::app()->db->createCommand('TRUNCATE menu_lang')->execute();
        Yii::app()->db->createCommand('TRUNCATE menu')->execute();
        foreach ($menu as $item) {
            $model = new Menu;
            $model->attributes = $item;
            $model->save();
        }
        Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
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
            Yii::app()->user->setFlash('success', Yii::t('app', 'Deleted'));

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionTree()
    {
        $menus = Menu::model()->findAll(array('order' => 'id ASC'));
        $array = array();

        foreach ($menus as $menu) {
            $url = $menu['link'];
            $menu_item = ($url) ? CHtml::link($menu['title'], $url, array('target' => '_blank')) : $menu['title'];
            $array[] = array(
                'id' => $menu['id'],
                'text' => $menu_item . ' ' . CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', Yii::app()->controller->createUrl('update', array('id' => $menu['id']))),
                'parent_id' => $menu['parent_id']);
        }
        $tree = $this->buildTree($array);


        $this->render('tree', array('tree' => $tree));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {


        $pages = array_map(function($o) { return array("id"=>$o->id,"title" => $o->title);}, Page::model()->findAllByAttributes(array('active' => 1)));
        $posts = array_map(function($o) { return array("id"=>$o->id,"title" => $o->title);}, Article::model()->findAllByAttributes(array('active' => 1)));
        $post_categories = array_map(function($o) { return array("id"=>$o->id,"title" => $o->title);}, ArticleCategory::model()->findAll());
        $custom_link = new Menu;


        $in = 0;

        if (isset($_POST['AddPages'])) {
            foreach ($_POST['AddPages'] as $page_id) {
                $page = Page::model()->multilingual()->findByPk($page_id);

                if ($page) {
                    $menu = new Menu;
                    $menu->attributes = array(
                        'title' => $page->title,
                        'link' => (substr($page->slug, 0, 1) != '/') ? '/' . $page->slug : $page->slug,
                    );

                    foreach (Language::model()->findAll() as $l) {
                        $titleLang = 'title_' . $l->lang;
                        $linkLang = 'link_' . $l->lang;
                        $slugLang = 'slug_' . $l->lang;
                        $menu->$titleLang = $page->$titleLang;
                        $menu->$linkLang = $page->$slugLang;
                    }
                    $menu->save();
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
                }
            }
            $in = 1;
        }
        if (isset($_POST['AddPosts'])) {
            foreach ($_POST['AddPosts'] as $post_id) {
                $post = Article::model()->multilingual()->findByPk($post_id);
                if ($post) {
                    $menu = new Menu;
                    $menu->attributes = array(
                        'title' => $post->title,
                        'link' => '/article/' . $post->slug
                    );
                    foreach (Language::model()->findAll() as $l) {
                        $titleLang = 'title_' . $l->lang;
                        $linkLang = 'link_' . $l->lang;
                        $slugLang = 'slug_' . $l->lang;
                        $menu->$titleLang = $post->$titleLang;
                        $menu->$linkLang = '/article/' . $post->$slugLang;
                    }
                    $menu->save();
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
                }
            }
            $in = 2;
        }
        if (isset($_POST['AddPostCategories'])) {
            foreach ($_POST['AddPostCategories'] as $post_category_id) {
                $post_category = ArticleCategory::model()->multilingual()->findByPk($post_category_id);
                if ($post_category) {
                    $menu = new Menu;
                    $menu->attributes = array(
                        'title' => $post_category->title,
                        'link' => '/articleCategory/' . $post_category->slug,
                    );
                    foreach (Language::model()->findAll() as $l) {
                        $titleLang = 'title_' . $l->lang;
                        $linkLang = 'link_' . $l->lang;
                        $menu->$titleLang = $post_category->title_en;
                        $menu->$linkLang = '/articleCategory/' . $post_category->slug_en;
                    }
                    $menu->save();
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
                }
            }
            $in = 3;
        }
        if (isset($_POST['Menu'])) {

            $custom_link->attributes = $_POST['Menu'];
            if (substr($custom_link->link, 0, 4) != 'http') {
                $custom_link->link = '//' . $custom_link->link;
            }
            if ($custom_link->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Saved'));
                $custom_link->title = '';
                $custom_link->link = '#';
            }

            $in = 4;

        } else {
            $custom_link->link = '#';
        }
        $menu = Yii::app()->db->createCommand("SELECT * FROM menu ORDER BY id")->queryAll();
        $model = $this->buildTree($menu);


        $this->render('index', array(
            'model' => $model,
            'pages' => $pages,
            'posts' => $posts,
            'post_categories' => $post_categories,
            'custom_link' => $custom_link,
            'in' => $in,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoadparents()
    {
        $data = Menu::model()->findAllByAttributes(array('language_id' => (int)$_POST['language_id'], 'active' => '1'), 'id <> ' . (int)$_POST['id']);
        $data = CHtml::listData($data, 'id', 'title');
        echo CHtml::tag('option', array('' => ''), Chtml::encode(""), true);
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    private function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {

            if ($element['parent_id'] == $parentId) {

                $children = $this->buildTree($elements, $element['id']);

                if ($children) {

                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

}
