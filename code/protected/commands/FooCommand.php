<?php
class FooCommand extends CConsoleCommand
{
    // 命令行示例 php yiic.php foo bar --testParams=xxx
    public function actionBar($testParams='all') 
    {
        var_dump($testParams);
    }

}

