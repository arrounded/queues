<?php

namespace Arrounded\Queues;

use Arrounded\Queues\Values\JobDescription;

class Queues
{
	const PRIORITY_HIGH = 'high';
	const PRIORITY_NONE = 'normal';
	const PRIORITY_LOW = 'low';

	/**
	 * @var string
	 */
	protected $prefix;

	/**
	 * @var string
	 */
	protected $priority;

	/**
	 * @var array
	 */
	protected $params = [];

	public function __construct()
	{
		$this->priority = static::PRIORITY_NONE;
	}

	/**
	 * @param string $prefix
	 *
	 * @return Queues
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}

	/**
	 * @param string $queue
	 *
	 * @return $this
	 */
	public function on($queue)
	{
		$this->params['queue'] = $queue;

		return $this;
	}

	/**
	 * @param string $class
	 *
	 * @return $this
	 */
	public function uses($class)
	{
		$this->params['class'] = $class;

		return $this;
	}

	/**
	 * @param array $payload
	 *
	 * @return $this
	 */
	public function with(array $payload = [])
	{
		$this->params['payload'] = $payload;

		return $this;
	}

	/**
	 * @return JobDescription
	 */
	public function push()
	{
		$job = new JobDescription(
			$this->getQueueName(array_get($this->params, 'queue')),
			array_get($this->params, 'class'),
			array_get($this->params, 'payload', [])
		);

		return $job;
	}

	/**
	 * @param $queue
	 *
	 * @return string
	 */
	protected function getQueueName($queue)
	{
		$parts = [$queue, $this->priority];

		if ($this->prefix) {
			array_unshift($parts, $this->prefix);
		}

		return implode('_', $parts);
	}
}