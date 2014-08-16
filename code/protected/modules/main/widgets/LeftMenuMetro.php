<?php


class LeftMenuMetro extends CWidget
{
    public $userid;
    public $type;
    public $currentRoute;
    public function run()
    {
        preg_match("/(^.*?)\?|(^.*)/",$_SERVER['REQUEST_URI'],$matchs);
        $currentRoute  = empty($matchs[1]) ? $matchs[2] : $matchs[1];
        $closeUser = Yii::app()->params['close_user'];
        if($closeUser) $actions = Action::model()->getAllMenu();
        else $actions = Privilege::getMenu($this->userid);
        $first = $second = array();
        foreach($actions as $v) {
            if($v['is_menu']==1) {
                $first[$v['aid']] = $v;
            } else if($v['is_menu']==2) {
                if(!isset($second[$v['first_menu']])) {
                    $second[$v['first_menu']] = array();
                }
                $second[$v['first_menu']][] = $v;
            }
        }
        $this->render('main.views.widget.left_menu_metro',array('first'=>$first,'second'=>$second));
    }

}
