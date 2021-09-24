<?php
namespace Sy\Event;

interface IEvent {

	/**
	 * Returns the Event name/identifier
	 *
	 * @return string
	 */
	public function getName() : string;

}