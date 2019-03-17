<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Tienvx\Messenger\MemoryTransport\Connection;
use Tienvx\Messenger\MemoryTransport\MemoryReceiver;

class MemoryReceiverTest extends TestCase
{
    public function testReceiver()
    {
        $connection = new Connection();
        $connection->publish('the first message');
        $connection->publish('the second message');
        $connection->publish('the third message');
        $connection->publish('the last message');

        $receiver = new MemoryReceiver($connection);
        $receiver->receive(function ($message) {
            $this->assertEquals('the first message', $message);
        });
        $receiver->stop();
        $this->assertEquals('the second message', $connection->get());
    }
}
