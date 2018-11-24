# Event Store
A simple easy to use Event Store implementation in PHP, supporting PDO out of the box.

```php
<?php

$eventStore = new InMemoryEventStore();

//append events
$eventStore->appendToStream($streamId, $events);

//read events
$stream = $eventStore->readStream($streamId);

//work with events
foreach ($stream as $event) {
    //..
}
```

## Table of Contents
* [Install](#install)
* [Conceptual](#conceptual)
* [Interfaces](#interfaces)
    + [EventStore](#eventstore)
    + [EventStream](#eventstream)
    + [StreamId](#streamid)
* [Pdo](#pdo)


## Install
```
composer require jeroenvanderlaan/event-store
```

## Conceptual
An event store keeps track of sequences of events, called event streams. The event store can read event streams, or append events to the end of an event stream. Pretty simple.

Each event stream is uniquely identifyable. And as stated, are made up from all events that were appended to it sequentially. How you wish to identify a stream, or what makes up an event, is completely up to you.

Consider a database table that stores each event as a row, along with its stream id.

|id|stream|event|
|-|-|-|
|1|stream-1|event-1|
|2|stream-2|event-2|
|3|stream-1|event-3|

The event store can read the stream by using the stream id.
```php
<?php
$id = new StreamId("stream-1")
$stream = $eventStore->readStream($id);
$events = iterator_to_array($stream); //event-1, event-3
```

And appending to the stream will result in new rows in the table
```php
<?php
$event = ["event-4"];
$eventStore->appendToStream($id, $event);
```
|id|stream|event|
|-|-|-|
|1|stream-1|event-1|
|2|stream-2|event-2|
|3|stream-1|event-3|
|4|stream-1|event-4|

## Interfaces
This packages comes with three important interfaces
* ```EventStore```
* ```EventStream```
* ```StreamId```

### EventStore
The ```EventStore``` interface defines the two essential methods for interacting with an event store, ```readStream``` and ```appendToStream```.

```readStream``` takes a ``StreamId`` and an optional options ```array```. The stream id is used for reading the correct stream, while the options array is intended to allow for more fine grained custom control over how streams are read (like limiting search results).

```appendToStream``` also takes a ```streamId```, and an events ```iterable``` to append to the appropriate stream. The events themselves can be anything, as long as the underlying event store implementation supports it. In most cases, events will be composed of key value pairs, or simple data transfer objects. The event store should be able to extract the necessary data from the events in order to append them to a stream.

### EventStream
An ```EventStream``` is an ```IteratorAggregate```, allowing for traversal of its respective events. It has a ```StreamId``` and a metadata ```array```. Stream metadata can be used to describe the event stream if necessary, and should be assigned by the event store after reading the stream. But this is purely optional.

### StreamId
The ``StreamId`` interface simply defines a ```toString``` and an ```equals``` method. It represents a unique string identifier, and is used by the ```EventStore``` for reading and appending to its respective ```EventStream```. The implementation is entirely up to your application, but the string representations should always be distinct from one another.

## Pdo
This packages comes with a simple ```PdoEventStore``` implementation.
```php
<?php

 //your pdo connection
$pdo = new PDO("sqlite::memory:");

 //an adapter that knows how to query your database
$adapter = new MySchemaQueryAdapter();

//the pdo event store
$eventStore = new PdoEventStore($pdo, $adapter);
```
The ```PdoEventStore``` requires the use of a new interface, the ```QueryAdapater```. This interface simply defines methods for obtaining the queries to read and append events.
```php
<?php

class MySchemaQueryAdapter implements QueryAdapater
{
    public function getReadStreamQuery(StreamId $id, array $options = []): string
    {
        //example read stream query
        return "SELECT `event` FROM `event_store` WHERE stream_id = :id;";
    }

    public function getReadStreamParameters(StreamId $id, array $options = []): array
    {
        //parameters to use with the query
        return ["id" => $id->toString()];
    }
    
    //..
}
```
In order to start using the ```PdoEventStore```, you will have to provide it with your own ```QueryAdapater``` implementation that supports the pdo driver and tables that you use.

Internally, the ```PdoEventStore``` binds the query and parameters to a ```PDOStatement```, and executes it. The ```PDOStatement``` is then used as the events ```iterable``` for the returned ```EventStream```. Each time the stream yields an event, ```PDOStatement::fetch()``` is called, meaning that the event stream is comprised of the rows of your read stream query resultset.
```php
<?php
$id = new StreamId("stream-1");
$stream = $eventStore->readStream($id);

//assuming your table has an "event" column
foreach ($stream as $row) {
    $event = $row["event"];
}
```
You can ofcourse extend and decorate this implementation as you see fit.
