<?php

namespace Jeroenvanderlaan\EventStore\Pdo;

use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Util\IterableEventStream;

class PdoEventStream extends IterableEventStream
{
    /**
     * @var \PDOStatement
     */
    private $statement;

    /**
     * PdoEventStream constructor.
     * @param StreamId $id
     * @param array $metadata
     * @param \PDOStatement $statement
     */
    public function __construct(StreamId $id, array $metadata, \PDOStatement $statement)
    {
        parent::__construct($id, $metadata, $statement);
        $this->statement = $statement;
    }

    /**
     * @return \Iterator
     */
    public function getIterator(): \Iterator
    {
        while ($event = $this->statement->fetch()) {
            yield $event;
        }
    }

}