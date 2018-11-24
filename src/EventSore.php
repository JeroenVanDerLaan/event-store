<?php

namespace Jeroenvanderlaan\EventStore;

interface EventSore
{
    /**
     * @param StreamId $id
     * @param array $options
     * @return EventStream
     */
    public function readStream(StreamId $id, array $options = []): EventStream;

    /**
     * @param StreamId $id
     * @param iterable $events
     */
    public function appendToStream(StreamId $id, iterable $events): void;
}