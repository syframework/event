<?php
namespace Sy\Event;

class EventDispatcher implements \Psr\EventDispatcher\EventDispatcherInterface {

	private $listenerProvider;

	public function __construct() {
		$this->listenerProvider = null;
	}

	/**
	 * Get the listener provider
	 *
	 * @return ListenerProvider
	 */
	public function getListenerProvider() {
		if (is_null($this->listenerProvider)) {
			$this->listenerProvider = new ListenerProvider();
		}
		return $this->listenerProvider;
	}

	/**
	 * Set the listener provider
	 *
	 * @param ListenerProvider $listenerProvider
	 * @return void
	 */
	public function setListenerProvider(ListenerProvider $listenerProvider) {
		$this->listenerProvider = $listenerProvider;
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
		$this->getListenerProvider()->addListener($eventName, $listener, $priority);
	}

	/**
	 * Provide all relevant listeners with an event to process.
	 *
	 * @param object $event The object to process.
	 * @return object The Event that was passed, now modified by listeners.
	 */
	public function dispatch(object $event) {
		$stoppable = $event instanceof \Psr\EventDispatcher\StoppableEventInterface;
		foreach ($this->getListenerProvider()->getListenersForEvent($event) as $listener) {
			if ($stoppable and $event->isPropagationStopped()) return;
			$listener($event);
		}
	}

}