<?php

namespace Mediator;

class Container
{
	/**
	 * @var IHandler[]
	 */
	private $handlers = [];

	/**
	 * @param IHandler $handler
	 * @return $this
	 * @throws \Exception
	 */
	public function add(IHandler $handler)
	{
		try {
			$queryClass = trim($handler->queryClass(), '\\\t\n\r\0\x0B');

			if (!class_exists($queryClass)) {
				throw new MediatorException(
					sprintf('Query class <%s> in handler <%s> not found', $queryClass, get_class($handler))
				);
			}

			$this->handlers[$queryClass][] = $handler;
			return $this;
		} catch (\Exception $e) {
			throw new MediatorException(sprintf('Exception while adding handler <%s>: %s', get_class($handler), $e->getMessage()), 0, $e);
		}
	}

	/**
	 * @param IQuery $query
	 * @return \Mediator\IHandler[]
	 * @throws \Exception
	 */
	public function all(IQuery $query)
	{
		$class = get_class($query);
		return isset($this->handlers[$class]) ? $this->handlers[$class] : [];
	}
}
