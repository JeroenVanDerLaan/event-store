<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit;

use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockStreamId;
use PHPUnit\Framework\TestCase;

abstract class EventStoreTest extends TestCase
{
    /**
     * @var EventSore
     */
    private $eventStore;

    /**
     * @var StreamId
     */
    private $streamIdFixture;

    /**
     * @var iterable
     */
    private $eventsFixture;

    protected function setUp()
    {
        $eventStore = $this->getEmptyEventStore();
        $id = new MockStreamId("stream-1");
        $events = $this->createEvents("event-1", "event-2");
        $eventStore->appendToStream($id, $events);

        $this->eventStore = $eventStore;
        $this->streamIdFixture = $id;
        $this->eventsFixture = $events;
    }

    abstract protected function getEmptyEventStore(): EventSore;

    abstract protected function createEvents(string ...$events): array;

    public function testThatExistingStreamIsRead(): void
    {
        $id = $this->streamIdFixture;
        $stream = $this->eventStore->readStream($id);
        $this->assertEquals($id, $stream->getId());
    }

    public function testThatExistingEventsAreRead(): void
    {
        $id = $this->streamIdFixture;
        $events = $this->eventsFixture;
        $stream = $this->eventStore->readStream($id);
        $this->assertEquals($events, iterator_to_array($stream));
    }

    public function testThatNonExistentStreamIsRead(): void
    {
        $id = new MockStreamId("stream-2");
        $stream = $this->eventStore->readStream($id);
        $this->assertEquals($id, $stream->getId());
    }

    public function testThatNonExistentStreamIsEmpty(): void
    {
        $id = new MockStreamId("stream-2");
        $stream = $this->eventStore->readStream($id);
        $this->assertEmpty(iterator_to_array($stream));
    }

    public function testThatEventsAreAppendedToEmptyStream(): void
    {
        $id = new MockStreamId("stream-2");
        $events = $this->createEvents("event-3", "event-4");
        $this->eventStore->appendToStream($id, $events);
        $stream = $this->eventStore->readStream($id);
        $this->assertEquals($events, iterator_to_array($stream));
    }

    public function testThatEventsAreAppendedToExistingStream(): void
    {
        $id = $this->streamIdFixture;
        $events = $this->createEvents("event-3", "event-4");
        $this->eventStore->appendToStream($id, $events);
        $events = array_merge($this->eventsFixture, $events);
        $stream = $this->eventStore->readStream($id);
        $this->assertEquals($events, iterator_to_array($stream));
    }
}