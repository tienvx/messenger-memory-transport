<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Tienvx\Messenger\MemoryTransport\Connection;
use Tienvx\Messenger\MemoryTransport\MemoryTransport;

class MemoryTransportTest extends TestCase
{
    public function testTransport()
    {
        $connection = new Connection();
        $connection->publish('the first message');
        $connection->publish('the second message');
        $connection->publish('the third message');
        $connection->publish('the last message');

        $transport = new MemoryTransport($connection);

        $transport->receive(function ($message) {
            $this->assertEquals('the first message', $message);
        });

        $transport->stop();

        $envelope = new Envelope((object) ['the final message']);
        $result = $transport->send($envelope);
        $this->assertInstanceOf(Envelope::class, $result);
        do {
            $message = $connection->get();
        } while (!$message instanceof Envelope);
        $this->assertEquals('the final message', ((array) $envelope->getMessage())[0]);
    }
}
