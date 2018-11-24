<?php

namespace Jeroenvanderlaan\EventStore;

interface StreamId
{
    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @param StreamId $id
     * @return bool
     */
    public function equals(StreamId $id): bool;
}