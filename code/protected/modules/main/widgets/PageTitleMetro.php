<?php


class PageTitleMetro extends CWidget
{
    public $userid;
    public function run()
    {
        preg_match("/(^.*?)\?|(^.*)/",$_SERVER['REQUEST_URI'],$matchs);
        $curRoute  = empty($matchs[1]) ? $matchs[2] : $matchs[1];
        $level = 1;
        $curAction = Action::model()->find("route=:route",array(":route"=>$curRoute));
        $firstAction = array();
        if($curAction['is_menu']==2) {
            $level = 2;
            $firstAction = Action::model()->findByPk($curAction['first_menu']);
        }
        $this->render('main.views.widget.page_title_metro',array('level'=>$level,'first'=>$firstAction,'curaction'=>$curAction));
    }

}
