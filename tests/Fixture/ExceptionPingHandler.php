<?php

namespace Mediator\Tests\Fixture;

use Mediator\IHandler;
use Mediator\IQuery;

class ExceptionPingHandler implements IHandler
{
	public function queryClass()
	{
		return 'Mediator\Tests\Fixture\Ping';
	}

	public function handle(IQuery $query)
	{
		throw new \Exception('Test exception');
	}
}
