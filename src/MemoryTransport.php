<?php

namespace Tienvx\Messenger\MemoryTransport;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Contracts\Service\ResetInterface;

class MemoryTransport implements TransportInterface, ResetInterface
{
    /**
     * @var Envelope[]
     */
    private $sent = [];

    /**
     * @var Envelope[]
     */
    private $acknowledged = [];

    /**
     * @var Envelope[]
     */
    private $rejected = [];

    /**
     * @var int
     */
    private $index = 0;

    /**
     * {@inheritdoc}
     */
    public function get(): iterable
    {
        return !empty($this->sent) ? [reset($this->sent)] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function ack(Envelope $envelope): void
    {
        $this->acknowledged[] = $envelope;
        $id = $this->findMessageIdStamp($envelope)->getId();
        unset($this->sent[$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function reject(Envelope $envelope): void
    {
        $this->rejected[] = $envelope;
        $id = $this->findMessageIdStamp($envelope)->getId();
        unset($this->sent[$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function send(Envelope $envelope): Envelope
    {
        $envelope = $envelope->with(
            new TransportMessageIdStamp($this->index)
        );
        $this->sent[$this->index] = $envelope;
        ++$this->index;

        return $envelope;
    }

    public function reset()
    {
        $this->sent = $this->rejected = $this->acknowledged = [];
        $this->index = 0;
    }

    /**
     * @return Envelope[]
     */
    public function getAcknowledged(): array
    {
        return $this->acknowledged;
    }

    /**
     * @return Envelope[]
     */
    public function getRejected(): array
    {
        return $this->rejected;
    }

    private function findMessageIdStamp(Envelope $envelope): TransportMessageIdStamp
    {
        /** @var TransportMessageIdStamp|null $messageIdStamp */
        $messageIdStamp = $envelope->last(TransportMessageIdStamp::class);

        if (null === $messageIdStamp) {
            throw new LogicException('No TransportMessageIdStamp found on the Envelope.');
        }

        return $messageIdStamp;
    }
}
