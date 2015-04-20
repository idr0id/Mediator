<?php

namespace Mediator\Tests\Fixture;

use Mediator\ICommandHandler;
use Mediator\ICommand;

class ExceptionHandler implements ICommandHandler
{
	public function isSatisfiedBy(ICommand $command)
	{
		return $command instanceof Ping;
	}

	public function handle(ICommand $command)
	{
		throw new \Exception('Test exception');
	}
}
