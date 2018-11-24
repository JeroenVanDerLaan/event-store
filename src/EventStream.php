<?php

namespace Jeroenvanderlaan\EventStore;

interface EventStream extends \IteratorAggregate
{
    /**
     * @return StreamId
     */
    public function getId(): StreamId;

    /**
     * @return array
     */
    public function getMetadata(): array;
}