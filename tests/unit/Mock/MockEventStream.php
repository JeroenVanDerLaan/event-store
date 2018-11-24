<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Mock;

use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;
use Traversable;

class MockEventStream implements EventStream
{
    /**
     * @var StreamId
     */
    private $id;

    /**
     * MockEventStream constructor.
     * @param StreamId $id
     */
    public function __construct(StreamId $id)
    {
        $this->id = $id;
    }

    /**
     * @return StreamId
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
        return [];
    }

    /**
     * @return iterable
     */
    public function getEvents(): iterable
    {
        return [];
    }

    /**
     * @return \EmptyIterator|Traversable
     */
    public function getIterator()
    {
        return new \EmptyIterator();
    }

}