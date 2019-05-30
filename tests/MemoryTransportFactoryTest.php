<?php

namespace Tienvx\Messenger\MemoryTransport\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Tests\Fixtures\DummyMessage;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Tienvx\Messenger\MemoryTransport\MemoryTransport;
use Tienvx\Messenger\MemoryTransport\MemoryTransportFactory;

class MemoryTransportFactoryTest extends TestCase
{
    public function testFactory()
    {
        $factory = new MemoryTransportFactory();
        $this->assertTrue($factory->supports('memory://any', []));
        $this->assertFalse($factory->supports('filesystem://any', []));

        $transport = $factory->createTransport('memory://any', [], $this->createMock(SerializerInterface::class));
        $this->assertInstanceOf(MemoryTransport::class, $transport);

        $transport->send(Envelope::wrap(new DummyMessage('Hello.')));

        $this->assertCount(1, $transport->get());
        $factory->reset();
        $this->assertCount(0, $transport->get());
    }
}
