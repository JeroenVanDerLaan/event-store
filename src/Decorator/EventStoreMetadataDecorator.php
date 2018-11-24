<?php

namespace Jeroenvanderlaan\EventStore\Decorator;

use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Util\IterableEventStream;

abstract class EventStoreMetadataDecorator extends EventStoreDecorator
{
    /**
     * @param StreamId $id
     * @param array $options
     * @return EventStream
     */
    public function readStream(StreamId $id, array $options = []): EventStream
    {
        $stream = parent::readStream($id, $options);
        $metadata = $this->getMetadata($stream);
        return new IterableEventStream($stream->getId(), $metadata, $stream->getEvents());
    }

    /**
     * @param EventStream $stream
     * @return array
     */
    abstract protected function getMetadata(EventStream $stream): array;
}