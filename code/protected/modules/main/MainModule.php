<?php
class MainModule extends CWebModule
{
    public $defaultController = 'site';

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(
            array(
                'main.components.*',
                'main.widgets.*',
                'main.models.*',
                'main.models.user.*'
            )
        );
        // Yii::app()->setComponents(array(
            // 'errorHandler' => array(
                // 'errorAction' => 'main/site/error',)
            // )
        // );
    }
}
