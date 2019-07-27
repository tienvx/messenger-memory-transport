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
        $this->assertCount(1, $messages);
        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the first message', $messages[0]->getMessage()->getMessage());
        $transport->ack($messages[0]);

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(1, $messages);
        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the second message', $messages[0]->getMessage()->getMessage());
        $transport->ack($messages[0]);

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(1, $messages);
        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the third message', $messages[0]->getMessage()->getMessage());
        $transport->reject($messages[0]);

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(1, $messages);
        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the last message', $messages[0]->getMessage()->getMessage());
        $transport->ack($messages[0]);

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(0, $messages);

        /** @var Envelope[] $messages */
        $messages = $transport->getAcknowledged();
        $this->assertCount(3, $messages);
        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the first message', $messages[0]->getMessage()->getMessage());
        $this->assertInstanceOf(DummyMessage::class, $messages[1]->getMessage());
        $this->assertEquals('the second message', $messages[1]->getMessage()->getMessage());
        $this->assertInstanceOf(DummyMessage::class, $messages[2]->getMessage());
        $this->assertEquals('the last message', $messages[2]->getMessage()->getMessage());

        /** @var Envelope[] $messages */
        $messages = $transport->getRejected();
        $this->assertCount(1, $messages);
        $this->assertInstanceOf(DummyMessage::class, $messages[0]->getMessage());
        $this->assertEquals('the third message', $messages[0]->getMessage()->getMessage());

        $transport->reset();

        /** @var Envelope[] $messages */
        $messages = $transport->get();
        $this->assertCount(0, $messages);
    }
}
