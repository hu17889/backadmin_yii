<?php

class RoleAction extends MActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '`m-role-action`';
    }

    /**
     * findActions 
     *
     * 根据roleid获取actions
     * 
     * @param mixed $rid 
     * @return array(aid1,aid2)
     */
    public function findActions($rid)
    {
        $actions = $this->findAll('rid=:id',array(':id'=>$rid));
        $ret = array();
        foreach($actions as $v) {
            $ret[$v['aid']] = $v['menu_pos'];
        }
        return $ret;
    }

    /**
     * saveActions 
     * 
     * @param mixed $rid 角色id
     * @param array $actions  array(aid1=>pos,aid2=>pos)
     * @return void
     */
    public function saveActions($rid,array $actions)
    {
        $conn = Yii::app()->db_frame;
        $sql = "insert into `m-role-action` (rid,aid,menu_pos) values ";
        foreach($actions as $k=>$v) {
            $sql .= "({$rid},{$k},{$v}),";
        }
        $sql = trim($sql,',');
        $command = $conn->createCommand($sql);
        $command->execute();
    }
}
