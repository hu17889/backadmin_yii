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
        if(!session_id()) session_start();
        if(empty($_SESSION['user'])) return false;
        $user = explode('_',$_SESSION['user']);
        if(isset($user[0])) 
        {
            $u = User::model()->find('uid=:id',array(':id'=>$user[0]));
            if(!empty($u)) {
                $userInfo = User::model()->find('uid=:id',array(':id'=>$user[0]))->getAttributes();
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
        if(!session_id()) session_start();
        if($type!='mingwen')
            $pwd = self::pwdEncry($pwd);

        $user = User::model()->find('uname=:name and pwd=:pwd',array(':name'=>$name, ':pwd'=> $pwd));
        if (!empty($user))
        {
            $userInfo = $user->getAttributes();
            $_SESSION['user'] = $userInfo['uid'].'_'.md5($name.$pwd);
            return $userInfo;
        }

        return array();
    }

    static public function logout()
    {
        if(!session_id()) session_start();
            //var_dump(ini_get("session.use_cookies"));exit;
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    static public function pwdEncry($pwd)
	{
		return substr(md5($pwd),0,20);
	}

}


