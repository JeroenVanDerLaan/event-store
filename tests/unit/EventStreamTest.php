<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit;

use Jeroenvanderlaan\EventStore\EventStream;
use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockStreamId;
use PHPUnit\Framework\TestCase;

abstract class EventStreamTest extends TestCase
{
    abstract protected function createEventStream(StreamId $id, array $metadata, iterable $events): EventStream;

    abstract protected function createEvents(string ...$events): array;

    public function testThatGivenIdIsSet(): void
    {
        $id = new MockStreamId("id");
        $stream = $this->createEventStream($id, [], []);
        $id = $id->toString();
        $streamId = $stream->getId()->toString();
        $this->assertEquals($id, $streamId);
    }

    public function testThatGivenMetadataIsSet(): void
    {
        $id = new MockStreamId("id");
        $metadata = ["key" => "value"];
        $stream = $this->createEventStream($id, $metadata, []);
        $intersect = array_intersect_assoc($metadata, $stream->getMetadata());
        $this->assertEquals($metadata, $intersect);
    }

    public function testThatGivenEventsCanBeIteratedOver(): void
    {
        $id = new MockStreamId("id");
        $events = $this->createEvents("event-1", "event-2");
        $stream = $this->createEventStream($id, [], $events);
        $this->assertEquals($events, iterator_to_array($stream));
    }
}