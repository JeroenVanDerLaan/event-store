<?php

namespace Jeroenvanderlaan\EventStore\Tests\Component\Pdo;

use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\Pdo\PdoEventStore;
use Jeroenvanderlaan\EventStore\Tests\Unit\EventStoreTest;

class PdoEventStoreTest extends EventStoreTest
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

    protected function getEmptyEventStore(): EventSore
    {
        $this->dropTable();
        $this->createTable();
        return new PdoEventStore($this->pdo, $this->adapter);
    }

    protected function createEvents(string ...$events): array
    {
        $rows = [];
        foreach ($events as $event) {
            $rows[] = ["event" => $event];
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

}