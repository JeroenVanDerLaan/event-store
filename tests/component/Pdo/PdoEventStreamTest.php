<?php

namespace Jeroenvanderlaan\EventStore\Tests\Component\Pdo;

use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\Pdo\PdoEventStream;
use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Tests\Unit\EventStreamTest;

class PdoEventStreamTest extends EventStreamTest
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var ExampleQueryAdapter
     */
    private $adapter;

    public function setUp()
    {
        $this->pdo = new \PDO("sqlite::memory:");
        $this->adapter = new ExampleQueryAdapter();
        parent::setUp();
    }

    protected function createEventStream(StreamId $id, array $metadata, iterable $events): EventStream
    {
        $this->dropTable();
        $this->createTable();
        $this->insertEvents($id, $events);
        $statement = $this->readEvents($id);
        return new PdoEventStream($id, $metadata, $statement);
    }

    protected function createEvents(string ...$events): array
    {
        $rows = [];
        foreach ($events as $event) {
            $row["event"] = $event;
        }
        return $rows;
    }

    protected function createTable(): void
    {
        $query = $this->adapter->getCreateTableQuery();
        $this->pdo->exec($query);
    }

    protected function dropTable(): void
    {
        $query = $this->adapter->getDropTableQuery();
        $this->pdo->exec($query);
    }

    protected function insertEvents(StreamId $id, array $events): void
    {
        $query = $this->adapter->getReadStreamQuery($id, $events);
        $parameters = $this->adapter->getReadStreamParameters($id, $events);
        $this->pdo->prepare($query)->execute($parameters);
    }

    protected function readEvents(StreamId $id): \PDOStatement
    {
        $query = $this->adapter->getReadStreamQuery($id);
        $parameters = $this->adapter->getReadStreamParameters($id);
        $statement = $this->pdo->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute($parameters);
        return $statement;
    }
}