# sy/event

PSR-14 compatible event dispatcher provides an ability to dispatch events and listen to events dispatched

## Installation

Install the latest version with

```bash
$ composer require sy/event
```

## Basic Usage

```php
<?php

use Sy\Event\EventDispatcher;
use Sy\Event\Event;

$eventDispatcher = new EventDispatcher();

// Add an event listener on an event named "myEvent"
$eventDispatcher->addListener('myEvent', function (object $event) {
	echo 'An event occurs: ' . $event->getName();
});

// Dispatch an event called "myEvent"
$eventDispatcher->dispatch(new Event('myEvent'));

```