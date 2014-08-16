<?php

class InitSystem
{
    static public function initActions()
    {
        $actions = include(Yii::app()->basePath.'/config-dist/actions.php');
        foreach($actions as $k=>$v) {
            $action = new Action;
            $ret = $action->find('aname=:name',array(':name'=>$v['aname']));
            if(empty($ret)) {
                $action->aname = $v['aname'];
                $action->route = $v['route'];
                $action->is_menu = $v['is_menu'];
                $action->save();
            }
        }
    }

    static public function initRoles()
    {
    	
    	$roleArray = array('superman', 'teacher', 'student');
    	foreach($roleArray as $value)
    	{
    		$roleInfo = Role::model()->find("rname=:rname", array(":rname"=>$value));
    		if (!empty($roleInfo))
    		{
    			continue;
    		}
    		else 
    		{
    			$role = new Role();
    			$role->rname = $value;
    			$role->save();
    		}
    	}
    }

    static public function initUsers()
    {
    	
    }

    /**
     * makeSupperUser 
     *
     * 创建超极管理员
     * 
     * @param mixed $uname 
     * @param mixed $pwd 
     * @return bool
     */
    static public function initSupperUser($uname, $pwd)
    {
        $user = new User;
        $userInfo = $user->getUserWithRole('uname=:name',array(':name'=>$uname));
        if(empty($userInfo)) {
            // make user
            $user->uname = $uname;
            $user->email = '';
            $user->pwd = $pwd;
            $user->rid = 0;
            $user->save();
        }
        // make role
        $role = new Role;
        $rname = 'superman';
        $roleInfo = $role->find('rname=:name',array(':name'=>$rname));
        if(empty($roleInfo)) {
            $params = array(
                'name' => $rname,
                'actions' => array(),
            );
            $action = new Action;
            $actionList = $action->findAll();
            foreach($actionList as $k=>$v) {
                $params['actions'][] = $v['aid'];
            }
            $role->saveRole($params);
            // save rid
            $userInfo = $user->getUserWithRole('uname=:name',array(':name'=>$uname));
            $roleInfo = $role->find('rname=:name',array(':name'=>$rname));
            $user->updateByPk($userInfo[0]['uid'],array(
                'uname'=>$uname,
                'email'=>'',
                'pwd'=>$pwd,
                'rid'=>$roleInfo['rid'],
            ));
        } else {
            $params = array(
                'id' => $roleInfo['rid'],
                'name' => $rname,
                'actions' => array(),
            );
            $action = new Action;
            $actionList = $action->findAll();
            foreach($actionList as $k=>$v) {
                $params['actions'][] = $v['aid'];
            }
            $role->updateRole($params);
        }
        return true;
    }
}



