<?php

namespace Mediator\Tests\Fixture;

use Mediator\IQuery;

class Ping implements IQuery
{
	public $message;

	public function __construct($message)
	{
		$this->message = $message;
	}
}
