<?php

namespace Jeroenvanderlaan\EventStore\Util;

use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;

class IterableEventStream implements EventStream
{
    /**
     * @var SimpleStreamId
     */
    private $id;

    /**
     * @var array
     */
    private $metadata;

    /**
     * @var iterable
     */
    private $events;

    /**
     * IterableEventStream constructor.
     * @param StreamId $id
     * @param array $metadata
     * @param iterable $events
     */
    public function __construct(StreamId $id, array $metadata, iterable $events)
    {
        $this->id = $id;
        $this->metadata = $metadata;
        $this->events = $events;
    }

    /**
     * @return SimpleStreamId
     */
    public function getId(): StreamId
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @return \Iterator
     */
    public function getIterator(): \Iterator
    {
        foreach ($this->events as $event) {
            yield $event;
        }
    }
}