<?php

namespace Mediator\Tests\Fixture;

use Mediator\IHandler;
use Mediator\IQuery;

class AnotherPingHandler implements IHandler
{
	public function queryClass()
	{
		return '\Mediator\Tests\Fixture\Ping';
	}

	/**
	 * @param IQuery|Ping $query
	 * @return IQuery
	 */
	public function handle(IQuery $query)
	{
		return $query->message . ' another pong';
	}
}
