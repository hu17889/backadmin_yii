<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../',
    'name'=>'recommend servise',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'application.modules.main.models.*',
        'application.modules.main.models.user.*',
    ),

    'modules'=>array(
        'main',
        ),

        // application components
        'components'=>array(
            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'urlFormat'=>'path',
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),


            // 其他业务功能数据库配置，可与后台数据配置相同
            'db'=>array(
                'connectionString' => 'mysql:host=127.0.0.1;dbname=backadmin',
                'emulatePrepare' => true,
                'username' => 'backadmin',
                'password' => 'xxx',
                'charset' => 'utf8',
            ),

            // *** 后台数据库配置
            'db_frame'=>array(
                'class'=>'CDbConnection',
                'connectionString' => 'mysql:host=127.0.0.1;dbname=backadmin',
                'emulatePrepare' => true,
                'username' => 'backadmin',
                'password' => 'xxx',
                'charset' => 'utf8',
            ),

            'errorHandler'=>array(
                'errorAction'=>'site/error',
            ),
            'curl' => array(
                'class' => 'application.extensions.Curl',
                'options'=>array(
                    'timeout'=>60,
                    'setOptions'=>array(
                        CURLOPT_USERAGENT => 'open_zhushou/curl',
                    ),
                ),
            ),

            // 日志配置，日志在protected/runtime里面
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'trace, error, warning',
                    ),
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'info',
                        'logFile'=>'info.log',
                    ),
                ),
            ),
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=>array(
            // 用户登陆开关，false不需要登陆所有用户可访问，但需要创建路由，true需要登录
            'close_user'=>false,
            'horizontal_menu_layout' => false, // 是否横向菜单
        ),
    );
