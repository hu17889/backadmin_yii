<?php


class MActiveRecord extends CActiveRecord
{
    public function getDbConnection()
    {
        return Yii::app()->db_frame;
    }
}
