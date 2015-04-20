<?php

namespace Mediator\Tests\Fixture;

use Mediator\ICommandHandler;
use Mediator\ICommand;

class ModifierHandler implements ICommandHandler
{
	public function isSatisfiedBy(ICommand $command)
	{
		return $command instanceof Ping;
	}

	public function handle(ICommand $command)
	{
		/** @var Ping $command */
		$command->message .= ' modified by pong';
	}
}
