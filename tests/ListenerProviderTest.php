<?php

use Sy\Event\Event;
use Sy\Event\ListenerProvider;

class ListenerProviderTest extends \PHPUnit\Framework\TestCase {

	private $listenerProvider;

	protected function setUp() : void {
		$this->listenerProvider = new ListenerProvider();
	}

	public function testAddListener() {
		$event = new Event('foo');

		// Check if it is an empty iterable at first
		$listeners = $this->listenerProvider->getListenersForEvent($event);
		$this->assertIsIterable($listeners);
		if (is_array($listeners)) {
			$this->assertEmpty($listeners);
		} else {
			$this->assertEquals(0, iterator_count($listeners));
		}

		// Add a listener
		$listener = function ($event) {
			echo $event->getName();
		};
		$this->listenerProvider->addListener('foo', $listener);

		// Check if it is not an empty iterable now
		$listeners = $this->listenerProvider->getListenersForEvent($event);
		$this->assertIsIterable($listeners);
		if (is_array($listeners)) {
			$this->assertNotEmpty($listeners);
		} else {
			$this->assertGreaterThan(0, iterator_count($listeners));
		}

		// Check if listener is a callable
		$l = is_array($listeners) ? current($listeners) : $listeners->current();
		$this->assertIsCallable($l);
		$this->assertSame($listener, $l);
	}

}