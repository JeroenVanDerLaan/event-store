<?php

namespace Jeroenvanderlaan\EventStore\Pdo;

use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;

class PdoEventStore implements EventSore
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var QueryAdapter
     */
    private $adapter;

    /**
     * PdoEventStore constructor.
     * @param \PDO $pdo
     * @param QueryAdapter $adapter
     */
    public function __construct(\PDO $pdo, QueryAdapter $adapter)
    {
        $this->pdo = $pdo;
        $this->adapter = $adapter;
    }

    /**
     * @param StreamId $id
     * @param array $options
     * @return EventStream
     */
    public function readStream(StreamId $id, array $options = []): EventStream
    {
        $query = $this->adapter->getReadStreamQuery($id, $options);
        $parameters = $this->adapter->getReadStreamParameters($id, $options);
        $statement = $this->pdo->prepare($query);
        $statement->closeCursor();
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute($parameters);
        return new PdoEventStream($id, [], $statement);
    }

    /**
     * @param StreamId $id
     * @param iterable $events
     */
    public function appendToStream(StreamId $id, iterable $events): void
    {
        $query = $this->adapter->getAppendToStreamQuery($id, $events);
        $parameters = $this->adapter->getAppendToStreamParameters($id, $events);
        $statement = $this->pdo->prepare($query);
        $statement->closeCursor();
        $statement->execute($parameters);
    }

}