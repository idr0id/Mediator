<?php

namespace Mediator\Tests\Fixture;

use Mediator\IHandler;
use Mediator\IQuery;

class PingHandler implements IHandler
{
	public $messages = [];

	public function queryClass()
	{
		return 'Mediator\Tests\Fixture\Ping';
	}

	/**
	 * @param IQuery|Ping $query
	 * @return string
	 */
	public function handle(IQuery $query)
	{
		$this->messages[] = $str = $query->message . ' pong';
		return $str;
	}
}
