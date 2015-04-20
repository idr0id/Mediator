<?php

namespace Mediator;

interface ICommandHandler
{
	public function isSatisfiedBy(ICommand $command);
	public function handle(ICommand $command);
}
