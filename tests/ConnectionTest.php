<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Tienvx\Messenger\MemoryTransport\Connection;

class ConnectionTest extends TestCase
{
    public function testConnection()
    {
        $connection = new Connection();
        $this->assertFalse($connection->has());
        $connection->publish('the first message');
        $connection->publish('the second message');
        $connection->publish('the third message');
        $connection->publish('the last message');

        $this->assertTrue($connection->has());
        $this->assertEquals('the first message', $connection->get());
        $this->assertEquals('the second message', $connection->get());
        $this->assertTrue($connection->has());
        $connection->clear();
        $this->assertFalse($connection->has());
    }
}
