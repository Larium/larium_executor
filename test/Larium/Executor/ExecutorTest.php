<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Executor;

class MyCommand
{
    public function execute($message)
    {
        print_r($message);
    }
}

class ExecutorTest extends \PHPUnit_Framework_TestCase
{

    public function testExecuteExecutor()
    {
        $m = new Executor();
        $c = new MyCommand();

        $m->addCommand('start', function($message, $state) {
            var_dump('Priority 2');
        },2)->addCommand('start', function($message){
            var_dump('Priority 12');
        },12)->addCommand('start', array($c, 'execute'), 0)
        ;


        $m->execute('start');
    }
}
