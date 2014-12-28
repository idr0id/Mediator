<?php

namespace Mediator;

class Mediator
{
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function notify(IQuery $query)
	{
		$handlers = $this->container->all($query);

		if (!count($handlers)) {
			throw new MediatorException(sprintf('Handlers was not found for query of type <%s>', get_class($query)));
		}

		$result = [];
		foreach ($handlers as $handler) {
			$result[] = $handler->handle($query);
		}
		return $result;
	}
}
