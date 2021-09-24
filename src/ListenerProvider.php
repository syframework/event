<?php
namespace Sy\Event;

class ListenerProvider implements \Psr\EventDispatcher\ListenerProviderInterface {

	private $listeners;

	public function __construct() {
		$this->listeners = [];
	}

	/**
	 * Add a listener
	 *
	 * @param string $eventName
	 * @param callable $listener
	 * @return void
	 */
	public function addListener(string $eventName, callable $listener) {
		$this->listeners[$eventName][] = $listener;
	}

	/**
	 * @param object $event An event for which to return the relevant listeners.
	 * @return iterable<callable> An iterable (array, iterator, or generator) of callables.
	 *                            Each callable MUST be type-compatible with $event.
	 */
	public function getListenersForEvent(object $event) : iterable {
		$eventName = $event instanceof IEvent ? $event->getName() : get_class($event);
		return $this->listeners[$eventName] ?? [];
	}

}