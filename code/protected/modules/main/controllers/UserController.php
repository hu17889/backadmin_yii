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
        -5=>'邮箱不能为空',
        -6=>'用户已存在',
        -7=>'验证码错误',
    );
    public function actionInitSystem()
    {
        //todo 增加权限限制
        exit;
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
        $showregister = isset($_REQUEST['isreg']) ? $_REQUEST['isreg'] : '';
        //echo "<pre>";var_dump($_REQUEST);exit;
        if(!empty($_POST['name'])&&!empty($_POST['pwd'])) 
        {
            $loginUserInfo = Login::logins($_REQUEST['name'],$_REQUEST['pwd'],'notmingwen');
            //var_dump($_REQUEST,$loginUserInfo);exit;
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
                $this->render('login_soft', array('showregister' => $showregister,'error'=>1,'url'=>$url));
                exit;
            }
        }
        //echo "fuck,world";
        $this->render('login_soft',array(
            'url' => $url,
            'showregister' => $showregister,
        ));
    }

    //注册
    public function actionRegister()
    {
        $account = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
        $pwd = isset($_REQUEST['pwd']) ? trim($_REQUEST['pwd']) : '';
        $pwdConfirm = isset($_REQUEST['pwdconfirm']) ? trim($_REQUEST['pwdconfirm']) : '';

        //var_dump($account);//exit;
        //if (!$this->validateAccount($account)) {

        include_once Yii::app()->basePath . '/../securimage/securimage.php';
        $securimage = new Securimage();
        if ($securimage->check($_REQUEST['captcha_code']) == false) {
            $accountError = '验证码错误';
            $this->jsonResult(-7, array('info' => $accountError));
        }
        if (empty($account)) {
            $accountError = '用户名不能为空';
            $this->jsonResult(-3, array('info' => $accountError));
        }

        if (empty($pwd) || $pwd != $pwdConfirm) {
            $pwdError = '密码不能为空，两次密码要相同';
            $this->jsonResult(-4, array('info' => $pwdError));
        }

        $email = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
        if (empty($email)) {
            $emailError = '邮箱不能为空';
            $this->jsonResult(-5, array('info' => $emailError));
        }

        $ret = User::model()->findAll("uname=:name or email=:email",array(":name"=>$account,"email"=>$email));
        if(count($ret)>0) {
            $error = '用户已存在';
            $this->jsonResult(-6, array('info' => $error));
        }
        $user = new User();
        $user->uname = $account;
        $user->email = $email;
        $user->pwd = Login::pwdEncry($pwd);
        $user->rid = 2; // 登录用户 
        $user->save();
        $loginUserInfo = Login::logins($account,$pwd, 'notmingwen');
        if(empty($loginUserInfo))
        {
            $loginUserInfo = Login::logins($account,$pwd,'mingwen');
        }
        $this->jsonResult(0);
    }

    // AJAX 重置密码邮件发送
    public function actionResetpwdEmail()
    {
        $this->layout="";
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
        if(empty($email)) {
            $this->render("login_soft",array("infomsg"=>"信息有误")); exit;
        }
        $user = User::model()->findAll("email=:email or uname=:email",array(":email"=>$email));
        if(empty($user)) {
            $this->render("login_soft",array("infomsg"=>"信息有误")); exit;
        }
        $user = $user[0];
        $uid = $user->uid;

        $ret = Resetpwd::model()->findAll("uid=:uid",array(":uid"=>$uid));
        if(empty($ret)) {
            $resetpwd = new Resetpwd;
            $resetpwd->randkey = rand(0,999999999);
            $resetpwd->uid = $uid;
            $resetpwd->expired = time()+2*3600; 
            $resetpwd->save();
        } else if($ret[0]->expired<time()) {
            $resetpwd = $ret[0];
            $resetpwd->randkey = rand(0,999999999);
            $resetpwd->uid = $uid;
            $resetpwd->expired = time()+2*3600; 
            $resetpwd->save();
        } else {
            $resetpwd = $ret[0];
        }
        //echo "<pre>";var_dump($_SERVER);exit;
        

        $confirmid = md5($uid.$resetpwd->randkey);
        $url = "http://".$_SERVER['HTTP_HOST']."/main/user/resetpwd?confirmid={$confirmid}&u={$uid}";


        $this->layout="application.modules.main.views.layouts.email";
        $content = $this->render("email_reset_pwd",array('url'=>$url),true);
        $this->layout="";
        $mail = new Mail;
        $mail->isHtml();
        $ret = $mail->send($user->email,"美股时代-系统邮件",$content);
        if($ret) {
            $this->render("login_soft",array("infomsg"=>"发送成功")); exit;
        } else {
            $this->render("login_soft",array("infomsg"=>"发送失败")); exit;
        }
        //echo $content;
        //var_dump($user->email,$ret);
    }

    // 重置密码页面以及修改码验证
    public function actionResetpwd()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        $this->layout = '';
        $confirmid = isset($_REQUEST['confirmid']) ? $_REQUEST['confirmid'] : '';
        $uid = isset($_REQUEST['u']) ? $_REQUEST['u'] : '';
        $isreset = isset($_REQUEST['resetsub']) ? $_REQUEST['resetsub'] : '';

        if(empty($uid)||empty($confirmid)) {
            $this->render("login_soft",array("infomsg"=>"信息有误")); exit;
        }

        $user = User::model()->findByPk($uid);
        if(empty($user)) {
            $this->render("login_soft",array("infomsg"=>"信息有误"));exit;
        }
        $resetpwd = Resetpwd::model()->findAll("uid=:uid",array(":uid"=>$uid));
        if(empty($resetpwd)) {
            $this->render("login_soft",array("infomsg"=>"信息有误")); exit;
        }
        $resetpwd = $resetpwd[0];

        if($resetpwd->expired<time()) {
            $this->render("login_soft",array("infomsg"=>"重置链接过期，请重新申请")); exit;
        }
        if(md5($uid.$resetpwd->randkey)!=$confirmid) {
            $this->render("login_soft",array("infomsg"=>"信息有误")); exit;
        }

        if($isreset) {
            // 重置提交
            $repwd = isset($_REQUEST['repwd']) ? $_REQUEST['repwd'] : '';
            $repwdconfirm = isset($_REQUEST['repwdconfirm']) ? $_REQUEST['repwdconfirm'] : '';
            if($repwd!=$repwdconfirm) {
                $this->render("login_soft",array("infomsg"=>"两次输入密码不同")); exit;
            }
            
            $user->pwd = Login::pwdEncry($repwd);
            $user->save();
            $this->render("login_soft",array("infomsg"=>"密码修改成功")); exit;
        }

        $this->render("login_soft",array(
            "isresetpwd"=>"1",
            "confirmid"=>$confirmid,
            "u"=>$uid,
        )); exit;
    }

    public function actionResetpwdConfirm() 
    {

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
        $this->redirect('/site/index');
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
