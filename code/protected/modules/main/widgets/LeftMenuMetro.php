<?php


class LeftMenuMetro extends CWidget
{
    public $userid;
    public $allMenu; // bool 是否显示所有菜单项
    public $horiz; // bool 是否使用横向菜单
    public $type;
    public $currentRoute;
    public function run()
    {
        preg_match("/(^.*?)\?|(^.*)/",$_SERVER['REQUEST_URI'],$matchs);
        $currentRoute  = empty($matchs[1]) ? $matchs[2] : $matchs[1];
        //$closeUser = Yii::app()->params['close_user'];
        if($this->allMenu) $actions = Action::model()->getAllMenu();
        else $actions = Privilege::getMenu($this->userid);
        //var_dump($this->userid,$actions);exit;
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
        if(empty($this->horiz)) {
            $this->render('main.views.widget.left_menu_metro',array('first'=>$first,'second'=>$second));
        } else {
            $this->render('main.views.widget.horiz_menu_metro',array('first'=>$first,'second'=>$second));
        }
    }

}
