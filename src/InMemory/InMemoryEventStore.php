<?php

namespace Jeroenvanderlaan\EventStore\InMemory;

use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Util\EmptyEventStream;
use Jeroenvanderlaan\EventStore\Util\IterableEventStream;

class InMemoryEventStore implements EventSore
{
    /**
     * @var array
     */
    private $streams = [];

    /**
     * @param StreamId $id
     * @param array $options
     * @return EventStream
     */
    public function readStream(StreamId $id, array $options = []): EventStream
    {
        if (!isset($this->streams[$id->toString()])) {
            return new EmptyEventStream($id, []);
        }
        return $this->streams[$id->toString()];
    }

    /**
     * @param StreamId $id
     * @param iterable $events
     */
    public function appendToStream(StreamId $id, iterable $events): void
    {
        $stream = $this->readStream($id);
        $metadata = $stream->getMetadata();
        $stream = iterator_to_array($stream);
        $events = array_merge($stream, $events);
        $this->streams[$id->toString()] = new IterableEventStream($id, $metadata, $events);
    }

}