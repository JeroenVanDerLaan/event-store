<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Decorator;

use Jeroenvanderlaan\EventStore\Decorator\EventStoreMetadataDecorator;
use Jeroenvanderlaan\EventStore\EventSore;
use Jeroenvanderlaan\EventStore\Tests\Unit\Decorator\Mock\MockEventStoreMetadataDecorator;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockEventStream;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockStreamId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EventStoreMetadataDecoratorTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $eventStoreMock;

    /**
     * @var EventStoreMetadataDecorator
     */
    private $eventStoreDecorator;

    /**
     * @var array
     */
    private $metadata;

    public function setUp()
    {
        /** @var EventSore $mock */
        $mock = $this->createMock(EventSore::class);
        $decorator = new MockEventStoreMetadataDecorator($mock);
        $metadata = ["key" => "value"];
        $decorator->setMetadata($metadata);

        $this->eventStoreMock = $mock;
        $this->eventStoreDecorator = $decorator;
        $this->metadata = $metadata;
    }

    public function testThatMetadataIsSetOnReadEventStream(): void
    {
        $id = new MockStreamId("id");
        $stream = new MockEventStream($id);
        $this->eventStoreMock
            ->method("readStream")
            ->willReturn($stream);

        $result = $this->eventStoreDecorator->readStream($id);
        $this->assertEquals($this->metadata, $result->getMetadata());
    }
}