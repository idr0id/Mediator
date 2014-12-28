<?php

namespace Mediator\Tests;

use Mediator\Container;
use Mediator\Mediator;
use Mediator\Tests\Fixture\AnotherPingHandler;
use Mediator\Tests\Fixture\Ping;
use Mediator\Tests\Fixture\PingHandler;
use Mediator\Tests\Fixture\Simple;

class MediatorTest extends \PHPUnit_Framework_TestCase
{
	public function testHandling()
	{
		$container = (new Container)->add($handler = new PingHandler());
		$mediator = new Mediator($container);

		$mediator->notify(new Ping('ping1'));
		$mediator->notify(new Ping('ping2'));

		$this->assertCount(2, $handler->messages);
		$this->assertEquals('ping1 pong', $handler->messages[0]);
		$this->assertEquals('ping2 pong', $handler->messages[1]);
	}

	public function testResult()
	{
		$container = (new Container)
			->add(new PingHandler())
			->add(new AnotherPingHandler());
		$mediator = new Mediator($container);

		$result = $mediator->notify(new Ping('ping'));

		$this->assertCount(2, $result);
		$this->assertContains('ping pong', $result);
		$this->assertContains('ping another pong', $result);
	}

	public function testException()
	{
		$this->setExpectedException('Mediator\MediatorException', 'Handlers was not found for query of type <Mediator\\Tests\\Fixture\\Ping>');

		$mediator = new Mediator(new Container());
		$mediator->notify(new Ping(''));
	}
}
