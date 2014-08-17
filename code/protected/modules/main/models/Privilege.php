<?php


class Privilege
{
    /**
     * getActions 
     *
     * 获取用户的可访问action列表
     * 
     * @param mixed $uid 
     * @return void
     */
    static public function getActions($uid)
    {
        $userInst = new User;
        $userInfo = $userInst->getUserWithAction('uid=:id',array(':id'=>$uid));
        $ret = array();
        foreach($userInfo as $k=>$v) {
            $ret[] = array(
                'aname' => $v['aname'],
                'route' => $v['route'],
                'is_menu' => $v['is_menu'],
            );
        }
        return $ret;
    }


    /**
     * getMenu 
     *
     * 获取用户的可访问菜单项
     * 
     * @param mixed $uid 
     * @return array(array(aname,route,is_menu))
     */
    static public function getMenu($uid)
    {
        $userInst = new User;
        $userInfo = $userInst->getUserWithAction('uid=:id order by menusort desc ,aname desc ',array(':id'=>$uid));
        $ret = array();
        foreach($userInfo as $k=>$v) {
            if($v['is_menu']) {
                $ret[] = array(
                    'aid' => $v['aid'],
                    'aname' => $v['aname'],
                    'route' => $v['route'],
                    'is_menu' => $v['is_menu'],
                    'first_menu' => $v['first_menu'],
                );
            }
        }
        //echo "<pre>";var_dump($userInfo);exit;
        return $ret;
    }

    /**
     * hasPrivilege 
     *
     * 判断是否当前用户是否有当前action的访问权限
     * 
     * @param mixed $uid 
     * @param mixed $route 
     * @return void
     */
    static public function hasPrivilege($uid,$route)
    {
        $menu = self::getActions($uid);
        foreach($menu as $k=>$v) {
            if($route==$v['route']) return true;
        }
        return false;
    }
}
