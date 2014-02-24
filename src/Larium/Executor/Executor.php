<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Executor;

class Executor
{
    protected $commands = array();

    public function addCommand($state, $command, $priority = 0)
    {
        if (!$this->hasState($state)) {
            $this->commands[$state] = new \SplPriorityQueue();
        }

        $this->commands[$state]->insert($command, $priority);

        return $this;
    }

    public function execute($state, Message $message = null)
    {

        if ($this->hasState($state)) {

            $message = $message ?: new Message();

            $message->setExecutor($this);

            $this->commands[$state]->top();

            while($this->commands[$state]->valid()) {

                call_user_func(
                    $this->commands[$state]->current(),
                    $message,
                    $state,
                    $this
                );
                $this->commands[$state]->next();
            }
        }
    }

    public function hasState($name)
    {
        return array_key_exists($name, $this->commands);
    }
}
