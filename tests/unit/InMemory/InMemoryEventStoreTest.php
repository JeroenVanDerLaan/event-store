<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\InMemory;

use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\InMemory\InMemoryEventStore;
use Jeroenvanderlaan\EventStore\Tests\Unit\EventStoreTest;

class InMemoryEventStoreTest extends EventStoreTest
{

    public function getEmptyEventStore(): EventSore
    {
        return new InMemoryEventStore();
    }

    protected function createEvents(string ...$events): array
    {
        return $events;
    }
}