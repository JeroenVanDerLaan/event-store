<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Mock;

use Jeroenvanderlaan\EventStore\StreamId;

class MockStreamId implements StreamId
{
    /**
     * @var string
     */
    private $id;

    /**
     * MockStreamId constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(StreamId $id): bool
    {
        return $this->id === $id->toString();
    }

}