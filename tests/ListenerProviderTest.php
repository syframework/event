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
		$this->assertEmpty($this->listenerProvider->getListenersForEvent($event));
		$listener = function ($event) {
			echo $event->getName();
		};
		$this->listenerProvider->addListener('foo', $listener);
		$listeners = $this->listenerProvider->getListenersForEvent($event);
		$this->assertIsArray($listeners);
		$this->assertIsCallable($listeners[0]);
		$this->assertSame($listener, $listeners[0]);
	}

}