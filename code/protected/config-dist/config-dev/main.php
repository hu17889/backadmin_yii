<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//
$hostname = exec('hostname');
$openbox_redis_config = array(
  'bjsc' => array(
      'host'  => '10.121.199.254',
      'port'  => '6236',
      'password'  => "71687afa4f4afa29",
  ),
  'shm' => array(
      'host'  => '10.130.113.254',
      'port'  => '6236',
      'password'  => "71687afa4f4afa29",
  ),
  'zwt' => array(
      'host'  => '10.131.199.254',
      'port'  => '6236',
      'password'  => "71687afa4f4afa29",
  ),
  'gzst' => array(
      'host'  => '10.168.232.245',
      'port'  => '6236',
      'password'  => "71687afa4f4afa29",
  ),
);

$openboxRedis = "";
if (strpos($hostname, 'shm') !== false) {
    $openboxRedis = $openbox_redis_config['shm'];
} else if (strpos($hostname, 'bjsc') !== false) {
    $openboxRedis = $openbox_redis_config['bjsc'];
} else if (strpos($hostname, 'gzst') !== false) {
    $openboxRedis = $openbox_redis_config['gzst'];
} else if (strpos($hostname, 'zwt') !== false) {
    $openboxRedis = $openbox_redis_config['zwt'];
} else {
    $openboxRedis = $openbox_redis_config['bjsc'];
}

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
        // uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'Enter Your Password Here',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
         */
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

            'cache' => array(
                'class' => 'application.extensions.CRedisCache',
                'servers'=>array(
                    array(
                        'host'=>'10.121.199.250',
                        //'host'=>'10.131.199.254',
                        'port'=>'6195',
                        'password'=>'74af911a593ea8d5',
                    ),
                ),
                'keyPrefix' => '',
            ),

            'cacheOpenbox' => array(
                'class' => 'application.extensions.CRedisCache',
                'servers'=>array(
                    $openboxRedis,
                ),
                'keyPrefix' => '',
            ),

            // sjbb
            'db'=>array(
                'connectionString' => 'mysql:host=123.125.83.240;dbname=sjbb',
                'emulatePrepare' => true,
                'username' => 'sjbb',
                'password' => 'sjbb',
                'charset' => 'utf8',
            ),

            'db_frame'=>array(
                'class'=>'CDbConnection',
                'connectionString' => 'mysql:host=10.16.15.79:3306;dbname=backadmin_yii',
                'emulatePrepare' => true,
                'username' => 'open',
                'password' => '8J6cn4A7f4SC2a7W',
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
            'close_user'=>true,
            // this is used in contact page
        ),
    );
