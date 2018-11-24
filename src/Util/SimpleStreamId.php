<?php

namespace Jeroenvanderlaan\EventStore\Util;

use Jeroenvanderlaan\EventStore\StreamId as StreamIdInterface;

class SimpleStreamId implements StreamIdInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * StreamId constructor.
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

    /**
     * @param StreamIdInterface $id
     * @return bool
     */
    public function equals(StreamIdInterface $id): bool
    {
        return $this->id === $id->toString();
    }

}