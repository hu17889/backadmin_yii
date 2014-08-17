<?php

class Role extends MActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '`m-role`';
    }

    /**
     * updateRole 
     *
     * 更新role信息，包括对应的action信息
     * 
     * @param array $params  array(id,name,actions(aid1,aid2))
     * @return void
     */
    public function updateRole(array $params)
    {
        //echo "<pre>";var_dump($params);exit;
        $this->updateByPk($params['id'],array(
            'rname'=>$params['name'],
        ));
        $roleaction = new RoleAction;
        $roleaction->deleteAll('rid=:id',array(':id'=>$params['id']));
        if(!empty($params['actions'])) {
            $ret = array();
            foreach($params['actions'] as $a) {
                if(isset($params['positions'][$a])) {
                    $ret[$a] = $params['positions'][$a];
                } else {
                    $ret[$a] = 0;
                }
            }
            $roleaction->saveActions($params['id'],$ret);
        }
    }

    /**
     * saveRole 
     *
     * 保存角色信息包括action
     * 
     * @param array $params 
     * @return void
     */
    public function saveRole(array $params)
    {
        $this->rname = $params['name'];
        $this->save();

        $roleInfo = $this->find('rname=:name', array(':name'=>$params['name']));
        $roleaction = new RoleAction;
        $roleaction->deleteAll('rid=:id',array(':id'=>$roleInfo['rid']));
        if(!empty($params['actions'])) {
            $ret = array();
            foreach($params['actions'] as $a) {
                if(isset($params['positions'][$a])) {
                    $ret[$a] = $params['positions'][$a];
                } else {
                    $ret[$a] = 0;
                }
            }
            $roleaction->saveActions($roleInfo['rid'],$ret);
        }
    }

    /**
     * findRole 
     *
     * 获取带有action的role信息
     * 
     * @param mixed $rid roleid
     * @return void
     */
    public function findRole($rid)
    {
        $roleInfo = $this->find('rid=:id',array(':id'=>$rid));
        if(!empty($roleInfo)) $roleInfo = $roleInfo->getAttributes();
        else return array();
        // get 该角色的action列表
        $roleInfo['actions'] = RoleAction::model()->findActions($rid);
        //echo "<pre>";var_dump($roleInfo['actions']);exit;
        return $roleInfo;
    }
}
