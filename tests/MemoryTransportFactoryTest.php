<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Tienvx\Messenger\MemoryTransport\Connection;
use Tienvx\Messenger\MemoryTransport\MemoryTransport;
use Tienvx\Messenger\MemoryTransport\MemoryTransportFactory;

class MemoryTransportFactoryTest extends TestCase
{
    public function testFactory()
    {
        $connection = new Connection();
        $connection->publish('the first message');
        $connection->publish('the second message');
        $connection->publish('the third message');
        $connection->publish('the last message');

        $factory = new MemoryTransportFactory($connection);
        $this->assertTrue($factory->supports('memory://any', []));
        $this->assertFalse($factory->supports('filesystem://any', []));
        $this->assertInstanceOf(MemoryTransport::class, $factory->createTransport('memory://any', []));
    }
}
