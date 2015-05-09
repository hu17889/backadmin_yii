<?php

class RoleController extends BackController
{
    public $layout = '/layouts/metronic';

    public function actionIndex()
    {
        $this->redirect('/main/role/list');
    }

    public function actionList()
    {
        $this->render('list',array());
    }

    public function actionGetRoleList()
    {
        $role = new Role;
        $roleInfos = $role->findAll(array('select'=>'rid,rname'));
        $ret = array();
        foreach($roleInfos as $role) {
            $ret[] = $role->getAttributes();
        }
        echo json_encode($ret);
    }

    public function actionListajax()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        $pageStart = isset($_REQUEST["iDisplayStart"]) ? intval($_REQUEST["iDisplayStart"]) : 0;
        $pageLen = isset($_REQUEST["iDisplayLength"]) ? intval($_REQUEST["iDisplayLength"]) : 10;
        $orderCol = isset($_REQUEST["iSortCol_0"]) ? intval($_REQUEST["iSortCol_0"]) : 0;
        $orderDir = isset($_REQUEST["sSortDir_0"])&&in_array($_REQUEST["sSortDir_0"], array("asc","desc")) ? $_REQUEST["sSortDir_0"] : "asc";
        $searchContent = isset($_REQUEST["sSearch"]) ? $_REQUEST["sSearch"] : "";

        // action column name
        $colNames = Role::model()->attributeNames();
        $totalNum = Role::model()->count();
        $numAfterFilter = Role::model()->count();
        $criteria=new CDbCriteria;
        $criteria->select = '*';  // 只选择 'title' 列
        if(!empty($searchContent)) {
            $criteria->condition = "rname like '%{$searchContent}%'";
        }
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $actionInfos = Role::model()->findAll($criteria);
        //var_dump($actionInfos);exit;

        $entitys = array();
        foreach ($actionInfos as $v) {
            $data = array(
                0=>$v['rid'],
                1=>$v['rname'],
                2=>'<a class="btn btn-sm red" href="/main/role/edit?id='.$v["rid"].'"><i class="fa fa-edit"></i></a> '.
                '<a class="delete btn btn-sm red" data-id="'.$v["rid"].'"><i class="fa fa-times"></i></a>',
            );
            $entitys[] = $data;
        }

        $retData = array(
            "sEcho" => intval($_REQUEST['sEcho']),
            "iTotalRecords" => $totalNum,
            "iTotalDisplayRecords" => $numAfterFilter,
            "aaData" => $entitys,
        );
        echo json_encode($retData);

    }

    public function actionDel()
    {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
        if($id!='') {
            $ret = Role::model()->deleteByPk($id);
            RoleAction::model()->deleteAll('rid=:rid',array(':rid'=>$id));
            var_dump($ret);
        } else {
            echo "fail";
        }
    }

    public function actionEdit()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        $role = new Role;
        $roleInfo = array();
        $label = '';
        foreach($_REQUEST as $k=>$v) {
            if($k!='actions'&&$k!='positions')
                $_REQUEST[$k] = trim($v);
        }
        // action 列表 展现
        $action = new Action;
        $actionList = $action->findAll('1=1 order by is_menu desc, route desc');
        $retActions = array();
        foreach ($actionList as $v) {
            $parts = explode("/",$v['route']);
            //if(!isset($parts[1])) continue;
            if(!isset($parts[1])) $retActions["noroute"][]=$v->getAttributes();
            $retActions[$parts[1]][] = $v->getAttributes();
        }
        //echo "<pre>";var_dump($retActions);exit;
        if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
            // 修改
            $roleInfo = $role->findRole($_REQUEST['id']);
            //echo "<pre>";var_dump($retActions,$roleInfo['actions']);exit;
            if(!empty($_REQUEST['modify'])) {
                $role->updateRole($_REQUEST);
                $this->redirect('/main/role/list');
            }
        } elseif(!empty($_REQUEST['name'])) {
            // 新增
            $roleInfo = $role->find('rname=:name',array(':name'=>$_REQUEST['name']));
            if(!empty($roleInfo)) {
                $roleInfo = $roleInfo->getAttributes();
                $roleInfo['actions'] = RoleAction::model()->findActions($roleInfo['rid']);
                $this->render('edit',array('action_list'=>$retActions,'entity'=>$roleInfo,'label'=>'has_role'));
                exit;
            }
            if(!empty($_REQUEST['modify'])) {
                $role->saveRole($_REQUEST);
                $this->redirect('/main/role/list');
            }
        }

        // foreach($actionList as $k=>$v) {
            // echo "<pre>";var_dump($k,$v->getAttributes());
        // }exit;
        $this->render('edit',array('action_list'=>$retActions,'entity'=>$roleInfo,'label'=>$label));
    }
}
