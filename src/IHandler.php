<?php

namespace Mediator;

interface IHandler
{
	public function queryClass();
	public function handle(IQuery $query);
}
