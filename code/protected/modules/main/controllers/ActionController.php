<?php

class ActionController extends BackController
{
    public $layout = '/layouts/metronic';

    public function actionIndex()
    {
        $this->redirect('/main/action/list');
    }

    public function actionList()
    {
        $this->render('list');
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
        $colNames = Action::model()->attributeNames();
        $totalNum = Action::model()->count();
        $numAfterFilter = Action::model()->count();
        $criteria=new CDbCriteria;
        $criteria->select = '*';  // 只选择 'title' 列
        if(!empty($searchContent)) {
            $criteria->condition = "aname like '%{$searchContent}%' or route like '%{$searchContent}%'";
        }
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $actionInfos = Action::model()->findAll($criteria);

        $entitys = array();
        foreach ($actionInfos as $v) {
            $t = Action::model()->find("aid={$v['first_menu']}");
            $data = array(
                0=>$v['aid'],
                1=>$v['aname'],
                2=>$v['route'],
                3=>$v['is_menu'],
                4=>$t['aname'],
                5=>$v['menusort'],
                6=>'<a class="btn btn-sm red" href="/main/action/edit?id='.$v["aid"].'"><i class="fa fa-edit"></i></a> '.
                '<a class="delete btn btn-sm red" data-id="'.$v["aid"].'"><i class="fa fa-times"></i></a>',
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
            $ret = Action::model()->deleteByPk($id);
            RoleAction::model()->deleteAll('aid=:aid',array(':aid'=>$id));
            var_dump($ret);
        } else {
            echo "fail";
        }
    }


    public function actionEdit()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        $action = new Action;
        $actionInfo = array();
        $label = '';
        foreach($_REQUEST as $k=>$v) {
            $_REQUEST[$k] = trim($v);
        }

        $menutype       = isset($_REQUEST['menu_type']) ? intval($_REQUEST['menu_type']) : '0';
        $whichFirstMenu = isset($_REQUEST['firstmenu']) ? intval($_REQUEST['firstmenu']) : '-1';
        $menusort       = isset($_REQUEST['menusort']) ? intval($_REQUEST['menusort']) : 0;
        $firstmenus     = Action::model()->findAll('is_menu=1');
        if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
            // 修改
            $actionInfo = $action->find('aid=:id',array(':id'=>$_REQUEST['id']));
            if(!empty($_REQUEST['modify'])) {
                $action->updateByPk($_REQUEST['id'],array(
                    'aname'     =>$_REQUEST['name'],
                    'route'     =>$_REQUEST['route'],
                    'is_menu'   =>$menutype,
                    'menusort'  =>$menusort,
                    'first_menu'=>$whichFirstMenu,
                ));
                $this->redirect('/main/action/list');
            }
        } elseif(!empty($_REQUEST['name'])) {
            // 新增
            $actionInfo = $action->find('aname=:name or route=:route',array(':name'=>$_REQUEST['name'],':route'=>$_REQUEST['route']));
            if(!empty($actionInfo)) {
                $this->render('edit',array(
                    'firstmenus'=>$firstmenus,
                    'entity'    =>$actionInfo,
                    'label'     =>'has_action',
                ));
                exit;
            }
            if(!empty($_REQUEST['modify'])) {
                $action->aname      = $_REQUEST['name'];
                $action->route      = $_REQUEST['route'];
                $action->is_menu    = $menutype;
                $action->first_menu = $whichFirstMenu;
                $action->menusort   = $menusort;
                $action->save();
                $this->redirect('/main/action/list');
            }
            //echo "<pre>";var_dump($_REQUEST,$actionInfo);exit;
        }

        $this->render('edit',array(
            'firstmenus'=>$firstmenus,
            'entity'=>$actionInfo,
            'label'=>$label,
        ));
    }
}
