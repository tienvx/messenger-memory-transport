<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Tests\Fixtures\DummyMessage;
use Tienvx\Messenger\MemoryTransport\MemoryTransport;

class MemoryTransportTest extends TestCase
{
    public function testTransport()
    {
        $transport = new MemoryTransport();

        $transport->send(Envelope::wrap(new DummyMessage('the first message')));
        $transport->send(Envelope::wrap(new DummyMessage('the second message')));
        $transport->send(Envelope::wrap(new DummyMessage('the third message')));
        $transport->send(Envelope::wrap(new DummyMessage('the last message')));

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(4, $messages);

        $transport->ack($messages[1]);
        $transport->reject($messages[3]);

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(2, $messages);

        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the first message', $messages[0]->getMessage()->getMessage());
        $this->assertInstanceOf(DummyMessage::class, $messages[2]->getMessage());
        $this->assertEquals('the third message', $messages[2]->getMessage()->getMessage());

        $transport->reset();

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(0, $messages);
    }
}
