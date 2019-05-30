<?php

namespace Tienvx\Messenger\MemoryTransport;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Contracts\Service\ResetInterface;

class MemoryTransportFactory implements TransportFactoryInterface, ResetInterface
{
    /**
     * @var MemoryTransport[]
     */
    private $createdTransports = [];

    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return $this->createdTransports[] = new MemoryTransport();
    }

    public function supports(string $dsn, array $options): bool
    {
        return 0 === strpos($dsn, 'memory://');
    }

    public function reset()
    {
        foreach ($this->createdTransports as $transport) {
            $transport->reset();
        }
    }
}
