<?php

class Action extends MActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '`m-action`';
    }

    public function getAllMenu()
    {
        $sql = "select * from `m-action` where is_menu>=1 order by menusort desc";
        $conn = Yii::app()->db_frame;
        $command = $conn->createCommand($sql);
        $rows = $command->queryAll();
        return $rows;
    }

}
