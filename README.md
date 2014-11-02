# 简介

此项目为一个php后台，基于历史项目，此处抽取出一个数据后台框架，方便其他项目迅速搭建后台；

基础功能健全，功能包括用户，登录，权限，功能点（路由）的管理；

外观样式采用metronic前端模板，还是不错的，支持横向菜单和纵向菜单；

简化后台可取消权限限制，无需用户登录；



后台基于php框架yii，以及模板metronic [下载链接](http://download.csdn.net/detail/loveyzy/6751593)

后台示例：http://backadmin.hucong.net/site/index  用户名:admin 密码:admin

![后台示例图片](http://backadmin.hucong.net/images/backadmin_temple.jpg)


# 部署流程

1. **部署代码**：到部署的目录，例如：/data/www/backadmin/，执行`git clone git@github.com:hu17889/backadmin_yii.git`，增加runtime目录（记录日志用）`cd code/protected;mkdir runtime;chmod 777 runtime`;

2. **部署数据库**：建立数据库backadmin，导入sql文件`backadmin.sql`;

3. **增加后台配置**：并执行`ln -s config-dist/config-temple config`;

4. **修改后台配置**：修改config/mian.php文件，增加数据库配置

  ```php
  
  // 其他业务功能数据库配置，可与后台数据配置相同
  'db'=>array(
      'connectionString' => 'mysql:host=127.0.0.1;dbname=backadmin',
      'emulatePrepare' => true,
      'username' => 'backadmin',
      'password' => 'xxx',
      'charset' => 'utf8',
  ),
  
  
  // *** 后台数据库配置
  'db_frame'=>array(
      'class'=>'CDbConnection',
      'connectionString' => 'mysql:host=127.0.0.1;dbname=backadmin',
      'emulatePrepare' => true,
      'username' => 'backadmin',
      'password' => 'xxx',
      'charset' => 'utf8',
  ),
  ```

5. **增加web服务配置**：nginx示例

  ```Nginx
  
  server {
  
    listen 80;
  
    server_name backadmin.net; 
  
    set $web_root /data/www/backadmin/code/; 
  
    root $web_root;
  
    index index.html index.htm index.php;
  
    
    # 处理后台模板
  
    location ~ /assets/ {
  
      rewrite ^(.*?)(/assets/.*)$ $2 break;
  
    }
  
    location / {
  
      if (!-e $request_filename) {
  
        rewrite (.*) /index.php last;
  
      }   
  
    }
  
    location ~ /*\.php$ {
  
        fastcgi_index  index.php;
  
        fastcgi_param  SCRIPT_FILENAME $web_root/$fastcgi_script_name;
  
        fastcgi_param  SCHEME $scheme;
  
        include        fastcgi_params;
  
        fastcgi_pass 127.0.0.1:9000;
  
    }
  
  }
  ```
6. 访问[http://backadmin.net/site/index](http://backadmin.net/site/index)


# 其他配置

1. 关闭用户登陆功能，使得所有用户都可以访问所有功能
    在config文件main.php里面设置`'close_user'=>true,`

2. 纵向菜单转为横向菜单
    `'horizontal_menu_layout' => true,`

# 基础功能说明

1. 用户管理

    如果开启了用户功能，则可以再用户管理功能里面对用户进行增删改查，以及设置用户的角色；

2. 路由管理

    路由代表/controller/action，可以设置为一级或者二级菜单或者非菜单功能，是一个权限限制的功能单元；

3. 角色管理

    角色管理中可以控制某个角色管理某一些路由，也就是权限管理。

