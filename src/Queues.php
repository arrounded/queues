<?php

namespace Arrounded\Queues;

use Arrounded\Queues\Values\JobDescription;
use Illuminate\Contracts\Queue\Queue;

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

	/**
	 * @var Queue
	 */
	protected $queue;

	/**
	 * @param Queue $queue
	 */
	public function __construct(Queue $queue)
	{
		$this->queue = $queue;
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
	 * @param string $priority
	 *
	 * @return $this
	 */
	public function priority($priority = self::PRIORITY_NONE)
	{
		$this->priority = $priority;

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

		$this->queue->push($job->getClass(), $job->getPayload(), $job->getQueue());

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