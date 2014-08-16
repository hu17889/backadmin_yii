<?php


class LeftMenu extends CWidget
{
    public $userid;
    public $type;
    public $currentRoute;
    public function run()
    {
        preg_match("/(^.*?)\?|(^.*)/",$_SERVER['REQUEST_URI'],$matchs);
        $currentRoute  = empty($matchs[1]) ? $matchs[2] : $matchs[1];
        $actions = Privilege::getMenu($this->userid);
        $content = " <ul class='left_nav_ul'> ";
        foreach($actions as $k=>$v) {
            if(preg_match("|^{$v['route']}|",$currentRoute)) {
                // 点击后
                $logopath = $v['logo_click'];
                $class = "click";
            } else {
                $logopath = $v['logo'];
                $class = "";
            }
            if($this->type=='logo'&&!empty($v['logo'])) {
                $content .= "
                    <li class='{$class}'><a href='{$v['route']}'><img src='{$logopath}' /></a></li>
                    ";
            } else {
                $content .= "
                    <li class='{$class}'><a href='{$v['route']}'>{$v['aname']}</a></li>
                    ";
            }
        }
        $content .= " </ul> ";
        $this->render('main.views.widget.left_menu',array('show'=>$content));
    }

}
