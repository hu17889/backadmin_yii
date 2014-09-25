<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../',
    'name'=>'recommend servise',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.models.cache.*',
        'application.models.mysql.*',
        'application.components.*',
        'application.extensions.*',
    ),

    /*
    'commandMap' => array(  
        'clean' => array(  
            'class' => 'ext.clean_command.ECleanCommand',  
            'webRoot' => 'E:\Apache2\htdocs\webapp', //注意修改 class::webRoot  
        ),  
        'rbac' => array(  
            'class' => 'application.commands.shell.RbacCommand',  
        )  
    ),
     */


    // application components
    'components'=>array(


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

        'curl' => array(
            'class' => 'application.extensions.Curl',
            'options'=>array(
                'timeout'=>60,
                'setOptions'=>array(
                    CURLOPT_USERAGENT => 'open_zhushou/curl',
                ),
            ),
        ),
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
        'zhushouredis'=>array(
            'bjsc' => array(
                'write' => '10.121.199.250',
                'read'  => '10.121.199.254',
                'port'  => '6236',
                'pass'  => "71687afa4f4afa29",
            ),
            'shm' => array(
                'write' => '10.130.113.253',
                'read'  => '10.130.113.254',
                'port'  => '6236',
                'pass'  => "71687afa4f4afa29",
            ),
            'zwt' => array(
                'write' => '10.131.199.249',
                'read'  => '10.131.199.254',
                'port'  => '6236',
                'pass'  => "71687afa4f4afa29",
            ),
            'gzst' => array(
                'write' => '10.168.232.245',
                'read'  => '10.168.232.245',
                'port'  => '6236',
                'pass'  => "71687afa4f4afa29",
            ),
        ),
        // this is used in contact page
    ),
);
