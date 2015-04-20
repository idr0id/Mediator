<?php

namespace Mediator\Tests\Fixture;

use Mediator\ICommand;

class Ping implements ICommand
{
	public $message;

	public function __construct($suffix = '')
	{
		$this->message = 'ping' . $suffix;
	}
}
