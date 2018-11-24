<?php

namespace Jeroenvanderlaan\EventStore\Util;

use Jeroenvanderlaan\EventStore\StreamId;

class EmptyEventStream extends IterableEventStream
{
    /**
     * EmptyEventStream constructor.
     * @param StreamId $id
     * @param array $metadata
     */
    public function __construct(StreamId $id, array $metadata)
    {
        parent::__construct($id, $metadata, []);
    }
};