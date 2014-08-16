<?php

class UserController extends BackController
{
    public $layout = '/layouts/metronic';

    const ACCOUNT_PATTERN = '/^[A-Za-z\x{4e00}-\x{9fa5}][A-Za-z0-9\x{4e00}-\x{9fa5}_-]{3,20}$/u';
    //const ACCOUNT_PATTERN = '/^[A-Za-z\x{4e00-\x{9fa5}}][A-Za-z0-9\x{4e00-\x{9fa5}_-}{2-20}]$/u';

    static $msgArray = array(0=>'成功',
        -1=>'参数错误',
        -2=>'操作失败',
        -3=>'账号不符合规则',
        -4=>'密码错误',
        -5=>'邮箱不能为空');
    public function actionInitSystem()
    {
        //todo 增加权限限制
        InitSystem::initActions();
        InitSystem::initSupperUser('superman','superman');
        InitSystem::initRoles();
    }

    public function actionIndex()
    {
        //$this->layout = "";
        //$this->render("/layouts/metronic");
        $this->redirect('/main/user/list');
    }

    public function actionListajax()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        $pageStart = isset($_REQUEST["iDisplayStart"]) ? intval($_REQUEST["iDisplayStart"]) : 0;
        $pageLen = isset($_REQUEST["iDisplayLength"]) ? intval($_REQUEST["iDisplayLength"]) : 10;
        $orderCol = isset($_REQUEST["iSortCol_0"]) ? intval($_REQUEST["iSortCol_0"]) : 0;
        $orderDir = isset($_REQUEST["sSortDir_0"])&&in_array($_REQUEST["sSortDir_0"], array("asc","desc")) ? $_REQUEST["sSortDir_0"] : "asc";
        $searchContent = isset($_REQUEST["sSearch"]) ? $_REQUEST["sSearch"] : "";

        // column name
        $colNames = User::model()->attributeNames();
        $totalNum = User::model()->count();
        $numAfterFilter = User::model()->count();
        $criteria=new CDbCriteria;
        $criteria->select = '*';  // 只选择 'title' 列
        if(!empty($searchContent)) {
            $criteria->condition = "uname like '%{$searchContent}%' or email like '%{$searchContent}%'";
        }
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $actionInfos = User::model()->findAll($criteria);
        //var_dump($actionInfos);exit;

        $entitys = array();
        foreach ($actionInfos as $v) {
            $t = Role::model()->find("rid={$v['rid']}");
            $data = array(
                0=>$v['uid'],
                1=>$v['uname'],
                2=>$v['email'],
                3=>$t['rname']  ,
                4=>'<a class="btn btn-sm red" href="/main/user/edit?id='.$v["uid"].'"><i class="fa fa-edit"></i></a> '.
                '<a class="delete btn btn-sm red" data-id="'.$v["uid"].'"><i class="fa fa-times"></i></a>',
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

    public function actionList()
    {
        $this->render('list');
    }

    public function actionEdit()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        $usr = new User;
        $role = new Role;
        $usrInfo = array();
        $label = '';
        foreach($_REQUEST as $k=>$v) {
            $_REQUEST[$k] = trim($v);
        }

        // 获取role列表
        $roleInfos = $role->findAll(array('select'=>'rid,rname'));
        // 过滤超极管理员
        foreach($roleInfos as $role) {
            if($role['rname']!='superman') $roles[] = $role;
        }
        // var_dump($_REQUEST); exit;
        // 
        if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
            // 修改
            $usrInfo = $usr->getUserWithRole('uid=:uid',array(':uid'=>$_REQUEST['id']));
            $usrInfo = $usrInfo[0];
            if(isset($_REQUEST['modify'])) {
                $usr->updateByPk($_REQUEST['id'],array(
                    'uname'=>$_REQUEST['name'],
                    'email'=>$_REQUEST['email'],
                    'pwd'=>Login::pwdEncry($_REQUEST['pwd']),
                    'rid'=>$_REQUEST['rid'],
                ));
                $this->redirect('/main/user/list');
            }
        } elseif(!empty($_REQUEST['name'])) {
            // 新增
            $usrInfo = $usr->getUserWithRole('uname=:name',array(':name'=>$_REQUEST['name']));
            //var_dump($usrInfo);exit;
            if(!empty($usrInfo)) {
                $this->render('edit',array('roles'=>$roles,'entity'=>$usrInfo[0],'label'=>'has_usr'));
                exit;
            }
            if(isset($_REQUEST['modify'])) {
                $usr->uname = $_REQUEST['name'];
                $usr->email = $_REQUEST['email'];
                $usr->pwd = Login::pwdEncry($_REQUEST['pwd']);
                $usr->rid = $_REQUEST['rid'];
                $usr->save();
                $this->redirect('/main/user/list');
            }
        }

        $this->render('edit',array('entity'=>$usrInfo,'roles'=>$roles,'label'=>$label));
    }

    //登录
    public function actionLogin()
    {
        $this->layout = '';
        $url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
        if(isset($_POST['login_sub'])&&!empty($_POST['name'])&&!empty($_POST['pwd'])) 
        {
            $loginUserInfo = Login::logins($_REQUEST['name'],$_REQUEST['pwd'],'notmingwen');
            // 兼容老的情况
            if(empty($loginUserInfo))
                $loginUserInfo = Login::logins($_REQUEST['name'],$_REQUEST['pwd'],'mingwen');
            if (!empty($loginUserInfo))
            {
                if (!empty($url) && $url != '/')
                {
                    $this->redirect($url);
                }
                else 
                {
                    $this->redirect('/site/index');
                }
            }
            else 
            {
                $this->render('login_soft', array('error'=>1,'url'=>$url));
                exit;
            }
        }
        //echo "fuck,world";
        $this->render('login_soft',array(
            'url' => $url,
        ));
    }

    //注册
    public function actionRegister()
    {
        $account = isset($_POST['name']) ? trim($_POST['name']) : '';
        $pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
        $pwdConfirm = isset($_POST['pwdconfirm']) ? trim($_POST['pwdconfirm']) : '';

        //var_dump($account);//exit;
        if (!$this->validateAccount($account))
        {
            //$this->render('/site/error',array('errortxt'=>$descError));
            //$errorDesc = '用户名只能包括英文字符汉字和数字，并且不能以数字开头,长度4-20个字符';
            //$this->render('/site/error', array('errortxt' => $errorDesc)); 
            //exit();
            $accountError = '用户名只能包括英文字符汉字和数字，并且不能以数字开头,长度4-20个字符';
            $this->jsonResult(-3, array('info' => $accountError));
        }

        if (empty($pwd) || $pwd != $pwdConfirm || strlen($pwd) < 6) 
        {
            $pwdError = '密码有误，至少6个字符';
            //$this->render('/site/error', array('errortxt' => '密码有误'));
            $this->jsonResult(-4, array('info' => $pwdError));
        }

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        if (empty($email))
        {
            $emailError = '邮箱必填,不能为空';
            $this->jsonResult(-5, array('info' => $emailError));
        }

        $user = new User();
        $user->uname = $account;
        $user->email = $email;
        $user->pwd = $pwd;
        $user->rid = 0; // 未分配角色 
        $user->save();
        $loginUserInfo = Login::logins($account,$pwd, 'notmingwen');
        if(empty($loginUserInfo))
        {
            $loginUserInfo = Login::logins($account,$pwd,'mingwen');
        }
        //$this->redirect('/student/courselist');
        $this->jsonResult(0);
    }

    // 锁屏
    public function actionLock()
    {
        $this->render("lock",array('url'=>$url));
    }

    // 退出
    public function actionLogout()
    {
        Login::logout();
        $this->redirect('/main/user/login');
    }

    // 删除用户
    public function actionDel()
    {
        User::model()->delUser($_REQUEST['id']);
    }

    public function validateAccount($account)
    {
        //echo "11111";exit;
        //echo $account;
        //$result = preg_match(self::ACCOUNT_PATTERN, $account, $match);
        //var_dump(self::ACCOUNT_PATTERN, $account,$result,$match);exit;
        if (preg_match(self::ACCOUNT_PATTERN, $account, $match))
        {
            //echo "fuck,world";exit;
            return true;
        }
        else
        {
            //echo "hello,world";exit;
            return false;
        }
    }
    public function jsonResult($retCode = 0, $info = array())
    {
        $result = array('retCode' => $retCode,
            'msg' => self::$msgArray[$retCode],
            'info' => $info);

        echo json_encode($result);
        exit;
    }
}
