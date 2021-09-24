<?php
namespace Sy\Event;

class Event implements IEvent, \Psr\EventDispatcher\StoppableEventInterface {

	private $name;

	private $data;

	private $stop;

	/**
	 * Create an event
	 *
	 * @param string $name The event identifier
	 * @param array $data Optionnal event parameters
	 */
	public function __construct(string $name, array $data = []) {
		$this->name = $name;
		$this->data = $data;
		$this->stop = false;
	}

	/**
	 * Stop the propagation of the event
	 *
	 * @return void
	 */
	public function stopPropagation() {
		$this->stop = true;
	}

	/**
	 * Get event name
	 *
	 * @return string
	 */
	public function getName() : string {
		return $this->name;
	}

	/**
	 * Get event data
	 *
	 * @return array
	 */
	public function getData() : array {
		return $this->data;
	}

	/**
     * Is propagation stopped?
     *
     * This will typically only be used by the Dispatcher to determine if the
     * previous listener halted propagation.
     *
     * @return bool
     *   True if the Event is complete and no further listeners should be called.
     *   False to continue calling listeners.
     */
	public function isPropagationStopped() : bool {
		return $this->stop;
	}

	/**
	 * Get event data
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		if (empty($this->data)) return null;
		if (!array_key_exists($name, $this->data)) return null;
		return $this->data[$name];
	}

}