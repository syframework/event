<?php
namespace Sy\Event;

class ListenerProvider implements \Psr\EventDispatcher\ListenerProviderInterface {

	/**
	 * Listeners array
	 *
	 * @var array
	 */
	private $listeners;

	/**
	 * Cache for listeners already sorted by priority
	 *
	 * @var array
	 */
	private $prioritySortedListerners;

	public function __construct() {
		$this->listeners = [];
		$this->prioritySortedListerners = [];
	}

	/**
	 * Add a listener
	 *
	 * @param string $eventName
	 * @param callable $listener
	 * @param integer $priority
	 * @return void
	 */
	public function addListener(string $eventName, callable $listener, int $priority = 0) {
		$this->listeners[$eventName][$priority][] = $listener;

		// Clear cache
		$this->prioritySortedListerners[$eventName] = [];
	}

	/**
	 * @param object $event An event for which to return the relevant listeners.
	 * @return iterable<callable> An iterable (array, iterator, or generator) of callables.
	 *                            Each callable MUST be type-compatible with $event.
	 */
	public function getListenersForEvent(object $event) : iterable {
		$eventName = $event instanceof IEvent ? $event->getName() : get_class($event);
		if (!isset($this->listeners[$eventName])) return [];

		// Cache hit
		if (!empty($this->prioritySortedListerners[$eventName])) {
			return $this->prioritySortedListerners[$eventName];
		}

		// Cache miss
		krsort($this->listeners[$eventName]);
		$this->prioritySortedListerners[$eventName] = array_merge(...$this->listeners[$eventName]);
		return $this->prioritySortedListerners[$eventName];
	}

}