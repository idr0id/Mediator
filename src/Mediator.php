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
		$result = [];
		foreach ($this->getHandlers($query) as $handler) {
			$result[] = $handler->handle($query);
		}
		return $result;
	}

	public function notifySafe(IQuery $query, \Closure $exceptionCallback = null)
	{
		$result = [];
		foreach ($this->getHandlers($query) as $handler) {
			try {
				$result[] = $handler->handle($query);
			} catch (\Exception $e) {
				if ($exceptionCallback) {
					$exceptionCallback($e);
				}
			}
		}
		return $result;
	}

	private function getHandlers(IQuery $query)
	{
		$handlers = $this->container->all($query);

		if (!count($handlers)) {
			throw new MediatorException(sprintf('Handlers was not found for query of type <%s>', get_class($query)));
		}
		return $handlers;
	}
}
