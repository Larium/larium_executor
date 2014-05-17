<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Executor;

class Executor
{
    protected $commands = array();

    public function addCommand($state, $command, $priority = 0)
    {
        if (!$this->hasState($state)) {
            $this->commands[$state][$priority] = array();
           // = new \SplPriorityQueue();
        }
        $this->commands[$state][$priority][] = $command;

        //$this->commands[$state]->insert($command, $priority);

        return $this;
    }

    /**
     * Executes commands assigned to given state and returns a Message object.
     *
     * @param string $state
     * @param Message $message
     * @access public
     * @return Message
     */
    public function execute($state, Message $message = null)
    {
        $message = $message ?: new Message();

        $message->setExecutor($this);

        if ($this->hasState($state)) {

            $queue = $this->create_queue($state);

            if ($queue->isEmpty()) {
                return;
            }

            $queue->top();

            while($queue->valid()) {

                call_user_func(
                    $queue->current(),
                    $message,
                    $state,
                    $this
                );
                $queue->next();
            }
        }

        return $message;
    }

    public function hasState($name)
    {
        return array_key_exists($name, $this->commands);
    }

    private function create_queue($state)
    {
        $queue = new \SplPriorityQueue();

        foreach ($this->commands[$state] as $priority => $commands) {
            foreach ($commands as $command) {
                $queue->insert($command, $priority);
            }
        }

        return $queue;
    }
}
