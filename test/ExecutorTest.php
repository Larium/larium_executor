<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Executor;

use PHPUnit\Framework\TestCase;

class MyCommand
{
    public function execute($message)
    {
        $message->addValue('Priority 100');
    }
}

class MyMessage extends Message
{
    private $values = array();

    public function addValue($value)
    {
        $this->values[] = $value;
    }

    public function getValues()
    {
        return $this->values;
    }
}

class ExecutorTest extends TestCase
{

    public function testExecuteExecutor()
    {
        $e = new Executor();
        $c = new MyCommand();
        $m = new MyMessage();


        $e->addCommand('start', function($message, $state) {
            $message->addValue('Priority 2');
        },2)->addCommand('start', function($message){
            $message->addValue('Priority 12');
        },12)->addCommand('start', array($c, 'execute'), 100)
        ;


        $message = $e->execute('start', $m);

        $values = $message->getValues();

        $this->assertTrue(is_array($values));

        $this->assertEquals(3, count($values));

        $this->assertEquals('Priority 100', array_shift($values));
        $this->assertEquals('Priority 12', array_shift($values));
        $this->assertEquals('Priority 2', array_shift($values));
    }
}
