<?php

namespace Mediator\Tests\Fixture;

use Mediator\ICommandHandler;
use Mediator\ICommand;

class StatefulHandler implements ICommandHandler
{
	public $messages = [];

	public function handle(ICommand $command)
	{
		/** @var Ping $command */
		$this->messages[] = $command->message . ' pong';
	}

	public function isSatisfiedBy(ICommand $command)
	{
		return $command instanceof Ping;
	}
}
