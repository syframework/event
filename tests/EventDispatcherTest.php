<?php

use Sy\Event\Event;
use Sy\Event\EventDispatcher;

$foo = 'bar';

class EventDispatcherTest extends \PHPUnit\Framework\TestCase {

	private $eventDispatcher;

	protected function setUp() : void {
		$this->eventDispatcher = new EventDispatcher();

		// Add an event listener on an event named "myEvent"
		$this->eventDispatcher->addListener('myEvent', function (object $event) {
			global $foo;
			$foo = 'baz';
		});
	}

	public function testDispatch() : void {
		global $foo;

		$this->assertEquals('bar', $foo);

		// Dispatch an event called "myEvent"
		$this->eventDispatcher->dispatch(new Event('myEvent'));

		$this->assertEquals('baz', $foo);
	}

}