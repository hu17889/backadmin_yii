<?php

class Login
{
    /**
     * getLoginInfo 
     *
     * 判断是否登陆并获取用户信息
     * 
     * @return false or array userInfo
     */
    static public function getLoginInfo()
    {
        if(empty($_COOKIE['user'])) return false;
        $user = explode('_',$_COOKIE['user']);
        if(isset($user[0])) 
        {
            $u = User::model()->find('uid=:id',array(':id'=>$user[0]));
            if(!empty($u)) {
                $userInfo = User::model()->find('uid=:id',array(':id'=>$user[0]))->getAttributes();
                $verify1 = md5($userInfo['uname'].$userInfo['pwd']);
                $verify2 = md5($userInfo['email'].$userInfo['pwd']);
                if($user[1]==$verify1||$user[1]==$verify2)
                    return $userInfo;
            } 
        }
        return false;
    }

    /**
     * login 
     *
     *  登录
     * 
     * @param mixed $name 
     * @param mixed $pwd 
     * @return bool
     */
    static public function logins($name, $pwd, $type='notmingwen')
    {
        //if(!session_id()) session_start();
        if($type!='mingwen')
            $pwd = self::pwdEncry($pwd);

        $user = User::model()->find('uname=:name and pwd=:pwd',array(':name'=>$name, ':pwd'=> $pwd));
        if (empty($user)) {
            $user = User::model()->find('email=:name and pwd=:pwd',array(':name'=>$name, ':pwd'=> $pwd));
        }
        //echo "<pre>";var_dump($name,$pwd,$user);exit;

        if (!empty($user)) {
            $userInfo = $user->getAttributes();
            $ret=setcookie('user',$userInfo['uid'].'_'.md5($name.$pwd),time()+10*24*3600,'/');
            //var_dump($ret,$_REQUEST,$userInfo,$pwd);exit;
            return $userInfo;
        }

        return array();
    }

    static public function logout()
    {
        setcookie('user','',-1,'/');
    }

    static public function pwdEncry($pwd)
    {
        return md5($pwd);
    }

}


