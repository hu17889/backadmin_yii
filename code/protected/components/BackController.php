<?php

class BackController extends Controller
{
    public $userid=0;
    public $userInfo = array();

    // 页面title
    public $actionName='';

    protected function beforeAction($action)
    {
        header("Cache-Control: no-cache, must-revalidate");
        date_default_timezone_set('PRC');

        // 登陆
        preg_match("/(^.*?)\?|(^.*)/",$_SERVER['REQUEST_URI'],$matchs);
        $requestUrl = empty($matchs[1]) ? $matchs[2] : $matchs[1];

        // 页面title
        $actionInfo = Action::model()->find("route=:route",array(':route'=>$requestUrl));
        if (!empty($actionInfo)) {
            $this->actionName = $actionInfo['aname'];
        }

        $closeUser = Yii::app()->params['close_user'];

        // 登陆限制
        if( $closeUser || (
            $_SERVER['REQUEST_URI']=='/main/user/logout' 
            || preg_match('|^/main/user/login|',$_SERVER['REQUEST_URI']) 
            || preg_match('|^/main/user/register|',$_SERVER['REQUEST_URI'])
            || $requestUrl=='/site/error'
        )) 
        {
            return true;
        }

        // get user info
        $userInfo = Login::getLoginInfo();
        $url = urlencode($_SERVER['REQUEST_URI']);
        if(empty($userInfo)) $this->redirect('/main/user/login?url='.$url);

        $this->userid = $userInfo['uid'];
        $this->userInfo = $userInfo;

        // 权限限制
        if($userInfo['uname']=='superman'&&!Privilege::hasPrivilege($userInfo['uid'],$requestUrl)
            && $requestUrl!='/site/index'
                && $requestUrl!='/main/user/lock'
            )
        {
            return false;
        }

        return true;
    }

}
