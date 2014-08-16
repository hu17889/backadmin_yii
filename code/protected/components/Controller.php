<?php
class Controller extends CController
{
    public $layout='';

    public function init()
    {
        // 通用model
        Yii::import("application.models.common.*");
        Yii::import("application.models.cache.*");
        Yii::import("application.models.mysql.*");
    }
}
