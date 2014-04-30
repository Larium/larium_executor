<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Executor;

class Message
{
    protected $executor;

    public function getExecutor()
    {
        return $this->executor;
    }

    public function setExecutor(Executor $executor)
    {
        $this->executor = $executor;
    }
}
