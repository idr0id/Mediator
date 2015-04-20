<?php

namespace Mediator;

/**
 * Class Mediator
 *
 * @package Mediator
 */
class Mediator
{
	/**
	 * @var ICommandHandler[]
	 */
	private $handlers = [];

	/**
	 * Register command handler
	 *
	 * @param ICommandHandler $handler
	 * @return $this
	 * @throws \Exception
	 */
	public function register(ICommandHandler $handler)
	{
		$class = get_class($handler);
		if (isset($this->handlers[$class])) {
			throw new MediatorException(sprintf('Handler <%s> already registered', get_class($handler)));
		}
		$this->handlers[$class] = $handler;

		return $this;
	}

	/**
	 * Handle command
	 *
	 * @param ICommand $command
	 * @param \Closure|null $exceptionCallback
	 * @throws MediatorException
	 */
	public function handle(ICommand $command, \Closure $exceptionCallback = null)
	{
		$isHandled = false;
		foreach ($this->handlers as $handler) {
			if (!$handler->isSatisfiedBy($command)) {
				continue;
			}

			$isHandled = true;

			try {
				$handler->handle($command);
			} catch (\Exception $e) {
				if (!$exceptionCallback) {
					throw new MediatorException('Unhandled exception while handling command <%s> by handler <%s>', 0, $e);
				}
				$exceptionCallback($e);
			}
		}

		if (!$isHandled) {
			throw new MediatorException(sprintf('Handlers were not found for command <%s>', get_class($command)));
		}
	}
}
