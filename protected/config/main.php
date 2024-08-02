<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', $_SERVER['DOCUMENT_ROOT'] .'/backend/protected/extensions/bootstrap/');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'CCMS',

    'language' => Yii::app()->language,
    // preloading 'log' component
    'preload' => array('log','booster','bootstrap'),
    // autoloading model and component classes
    'import' => array(
        
        'application.models.*',
        'application.components.*',
        'application.extensions.yiimailer.YiiMailer',
        'bootstrap.helpers.TbHtml',
        'application.extensions.editable',
        'application.extensions.MultilingualActiveRecord.*',

    ),
    'modules' => array(
    // uncomment the following to enable the Gii tool
    
      'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'0000',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
          'generatorPaths' => array(
            'ext.booster.gii'
        ),
      ),
     
    ),
    // application components
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        
        'booster' => array(
            'class' => 'ext.booster.components.Booster',
        ),
        'Helpers' => array(
            'class' => 'application.components.Helpers',
        ),
        'ImageTools' => array(
            'class' => 'application.components.ImageTools',
        ),
        
         
        // uncomment the following to enable URLs in path-format
        
          'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>/<size:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
         

        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
            */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'gotivac@gmail.com',
        'bundles' =>array(20, 50, 100, 200, 500),
        'vat' => 19,
        'google_client_id' => '654691408225-m27d4ulc2kf1p8l3jumm1ci88imhnv6r.apps.googleusercontent.com', // 437453127224-rikcihkprsdprj15qso3ov1paj5lju0m.apps.googleusercontent.com',
        'google_distance_matrix_api' => 'AIzaSyB_xC-iOykKwMUTJfEpmd1EaD5JB7rtodo',
        'google_geocoding_api' => 'AIzaSyBxo-eLk1t5qVjNDRGXqLZs2Kmzl06Nrv8',
        'adminDelete' => 'false',
        
    ),
    'behaviors'=>array(
        // if not logged in, go to login page
        'class'=>'application.components.ApplicationBehavior',
     ),
);
