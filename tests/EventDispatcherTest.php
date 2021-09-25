<?php

use Sy\Event\Event;
use Sy\Event\EventDispatcher;
use Sy\Event\ListenerProvider;

$foo = 'bar';
$count = 0;

class EventDispatcherTest extends \PHPUnit\Framework\TestCase {

	private $eventDispatcher;

	protected function setUp() : void {
		$this->eventDispatcher = new EventDispatcher();

		// Add an event listener on an event named "myEvent"
		$this->eventDispatcher->addListener('myEvent', function (object $event) {
			global $foo, $count;
			$foo = 'baz';
			$count++;
		});
		$this->eventDispatcher->addListener('myEvent', function (object $event) {
			global $count;
			$count++;
		});
	}

	protected function tearDown(): void {
		global $foo, $count;
		$foo = 'bar';
		$count = 0;
	}

	public function testDispatch() : void {
		global $foo, $count;

		$this->assertEquals('bar', $foo);

		// Dispatch an event called "myEvent"
		$this->eventDispatcher->dispatch(new Event('myEvent'));

		$this->assertEquals('baz', $foo);
		$this->assertEquals(2, $count);
	}

	public function testGetSetListenerProvider() {
		global $foo, $count;

		$listenerProvider = new ListenerProvider();
		$listenerProvider->addListener('myEvent', function (object $event) {
			global $foo, $count;
			$foo = 'hello';
			$count++;
		});

		$this->assertNotSame($listenerProvider, $this->eventDispatcher->getListenerProvider());

		$this->eventDispatcher->setListenerProvider($listenerProvider);

		$this->assertSame($listenerProvider, $this->eventDispatcher->getListenerProvider());

		// Dispatch an event called "myEvent"
		$this->eventDispatcher->dispatch(new Event('myEvent'));

		$this->assertEquals('hello', $foo);
		$this->assertEquals(1, $count);
	}

	public function testStopEventPropagation() {
		global $foo, $count;

		$listenerProvider = new ListenerProvider();
		$listenerProvider->addListener('myEvent', function (object $event) {
			global $foo, $count;
			$foo = 'hello';
			$count++;
			$event->stopPropagation();
		});
		$listenerProvider->addListener('myEvent', function (object $event) {
			global $foo, $count;
			$foo = 'world';
			$count++;
		});

		$this->eventDispatcher->setListenerProvider($listenerProvider);

		// Dispatch an event called "myEvent"
		$this->eventDispatcher->dispatch(new Event('myEvent'));

		$this->assertEquals('hello', $foo);
		$this->assertEquals(1, $count);
	}

	public function testEventPriority() {
		global $foo, $count;

		$listenerProvider = new ListenerProvider();
		$listenerProvider->addListener('myEvent', function (object $event) {
			global $foo, $count;
			$foo = 'hello';
			$count++;
		});
		$listenerProvider->addListener('myEvent', function (object $event) {
			global $foo, $count;
			$foo = 'world';
			$count++;
		}, 1);

		$this->eventDispatcher->setListenerProvider($listenerProvider);

		// Dispatch an event called "myEvent"
		$this->eventDispatcher->dispatch(new Event('myEvent'));

		$this->assertEquals('hello', $foo);
		$this->assertEquals(2, $count);
	}

}