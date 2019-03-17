<?php

namespace Tienvx\Messenger\MemoryTransport;

class Connection
{
    /**
     * @var array[]
     */
    private $messages = [];

    public function publish($message): void
    {
        $this->messages[] = $message;
    }

    public function get()
    {
        // Memory transport use FIFO (First In, First Out), not LIFO (Last In, First Out) as in
        // pnz/messenger-filesystem-transport
        return array_shift($this->messages);
    }

    public function has()
    {
        return count($this->messages) > 0;
    }

    public function clear()
    {
        $this->messages = [];
    }
}
