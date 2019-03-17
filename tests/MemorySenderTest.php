<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Tienvx\Messenger\MemoryTransport\Connection;
use Tienvx\Messenger\MemoryTransport\MemorySender;

class MemorySenderTest extends TestCase
{
    public function testSender()
    {
        $connection = new Connection();
        $connection->publish('the first message');
        $connection->publish('the second message');
        $connection->publish('the third message');
        $connection->publish('the last message');

        $sender = new MemorySender($connection);
        $envelope = new Envelope((object) ['the final message']);
        $result = $sender->send($envelope);
        $this->assertInstanceOf(Envelope::class, $result);
        do {
            $message = $connection->get();
        } while (!$message instanceof Envelope);
        $this->assertEquals('the final message', ((array) $message->getMessage())[0]);
    }
}
