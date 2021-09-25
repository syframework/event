<?php

use Sy\Event\Event;

class EventTest extends \PHPUnit\Framework\TestCase {

	private $event;

	protected function setUp() : void {
		$this->event = new Event('foo', ['id' => 123, 'type' => 'hello']);
	}

	public function testStopPropagation() {
		$this->assertFalse($this->event->isPropagationStopped());
		$this->event->stopPropagation();
		$this->assertTrue($this->event->isPropagationStopped());
	}

	public function testData() {
		$this->assertEquals(123, $this->event->id);
		$this->assertEquals('hello', $this->event->type);
	}

}