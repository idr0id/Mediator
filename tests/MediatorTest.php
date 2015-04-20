<?php

namespace Mediator\Tests;

use Mediator\Mediator;
use Mediator\Tests\Fixture\ModifierHandler;
use Mediator\Tests\Fixture\ExceptionHandler;
use Mediator\Tests\Fixture\Ping;
use Mediator\Tests\Fixture\StatefulHandler;

class MediatorTest extends \PHPUnit_Framework_TestCase
{
	public function testHandling()
	{
		// arrange
		$handler = new StatefulHandler();
		$mediator = (new Mediator())->register($handler);

		// act
		$mediator->handle(new Ping('1'));
		$mediator->handle(new Ping('2'));

		// assert
		$this->assertCount(2, $handler->messages);
		$this->assertEquals('ping1 pong', $handler->messages[0]);
		$this->assertEquals('ping2 pong', $handler->messages[1]);
	}

	public function testUnhandledException()
	{
		// arrange
		$mediator = (new Mediator())->register(new ExceptionHandler());
		$command = new Ping();

		// act
		$this->setExpectedException('Mediator\MediatorException');
		$mediator->handle($command);
	}

	public function testHandlingExceptionByCallback()
	{
		// arrange
		$handler = new StatefulHandler();
		$mediator = (new Mediator())
			->register(new ExceptionHandler())
			->register($handler);
		$exceptionMessage = '';

		// act
		$mediator->handle(new Ping(), function(\Exception $e) use (&$exceptionMessage) {
			$exceptionMessage = $e->getMessage();
		});

		// assert
		$this->assertEquals('Test exception', $exceptionMessage);
		$this->assertCount(1, $handler->messages);
		$this->assertEquals('ping pong', $handler->messages[0]);
	}

	public function testMultipleHandlers()
	{
		// arrange
		$handler = new StatefulHandler();
		$mediator = (new Mediator())
			->register($handler)
			->register(new ModifierHandler());

		$command = new Ping();

		// act
		$mediator->handle($command);

		// assert
		$this->assertEquals('ping pong', $handler->messages[0]);
		$this->assertContains('ping modified by pong', $command->message);
	}

	public function testException()
	{
		// arrange
		$mediator = new Mediator();

		// act
		$this->setExpectedException('Mediator\MediatorException', 'Handlers were not found for command <Mediator\\Tests\\Fixture\\Ping>');
		$mediator->handle(new Ping());
	}
}
