<?php

namespace Jeroenvanderlaan\EventStore\Pdo;

use Jeroenvanderlaan\EventStore\StreamId;

interface QueryAdapter
{
    /**
     * @param StreamId $id
     * @param array $options
     * @return string
     */
    public function getReadStreamQuery(StreamId $id, array $options = []): string;

    /**
     * @param StreamId $id
     * @param array $options
     * @return array
     */
    public function getReadStreamParameters(StreamId $id, array $options = []): array;

    /**
     * @param StreamId $id
     * @param iterable $events
     * @return string
     */
    public function getAppendToStreamQuery(StreamId $id, iterable $events): string;

    /**
     * @param StreamId $id
     * @param iterable $events
     * @return array
     */
    public function getAppendToStreamParameters(StreamId $id, iterable $events): array;
}