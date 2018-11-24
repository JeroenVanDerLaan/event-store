<?php

namespace Jeroenvanderlaan\EventStore\Decorator;

use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;

abstract class EventStoreDecorator implements EventSore
{
    /**
     * @var EventSore
     */
    private $eventStore;

    /**
     * EventStoreDecorator constructor.
     * @param EventSore $eventSore
     */
    public function __construct(EventSore $eventSore)
    {
        $this->eventStore = $eventSore;
    }

    /**
     * @param StreamId $id
     * @param array $options
     * @return EventStream
     */
    public function readStream(StreamId $id, array $options = []): EventStream
    {
        return $this->eventStore->readStream($id, $options);
    }

    /**
     * @param StreamId $id
     * @param iterable $events
     */
    public function appendToStream(StreamId $id, iterable $events): void
    {
        $this->eventStore->appendToStream($id, $events);
    }

}