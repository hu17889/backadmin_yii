<?php 

class BackadminController extends BackController
{
    public $layout = 'application.modules.main.views.layouts.metronic';//"application.modules.main.views.layouts.frame_without_leftnav";
    
    public function actionFoo()
    {
        $this->render("bar");
    }

}


