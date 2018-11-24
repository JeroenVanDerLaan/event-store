<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Decorator;

use Jeroenvanderlaan\EventStore\Decorator\EventStoreDecorator;
use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\Tests\Unit\Decorator\Mock\MockEventStoreDecorator;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockEventStream;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockStreamId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EventStoreDecoratorTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $eventStoreMock;

    /**
     * @var EventStoreDecorator
     */
    private $eventStoreDecorator;

    public function setUp()
    {
        /** @var EventSore $mock */
        $mock = $this->createMock(EventSore::class);
        $decorator = new MockEventStoreDecorator($mock);
        $this->eventStoreMock = $mock;
        $this->eventStoreDecorator = $decorator;
    }

    public function testThatReadStreamIsInvokedOnDecoratedEventStore(): void
    {
        $id = new MockStreamId("id");
        $this->eventStoreMock
            ->expects($this->atLeastOnce())
            ->method("readStream")
            ->with($id);
        $this->eventStoreDecorator->readStream($id);
    }

    public function testThatStreamFromDecoratedEventStoreIsRead(): void
    {
        $id = new MockStreamId("id");
        $stream = new MockEventStream($id);
        $this->eventStoreMock
            ->method("readStream")
            ->willReturn($stream);
        $result = $this->eventStoreDecorator->readStream($id);
        $this->assertEquals($stream, $result);
    }

    public function testThatAppendToStreamIsInvokedOnDecoratedEventStore(): void
    {
        $id = new MockStreamId("id");
        $events = [];
        $this->eventStoreMock
            ->expects($this->atLeastOnce())
            ->method("appendToStream")
            ->with($id, $events);
        $this->eventStoreDecorator->appendToStream($id, $events);
    }

}