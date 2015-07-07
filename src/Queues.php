<?php

namespace Arrounded\Queues;

use Arrounded\Queues\Values\JobDescription;

class Queues
{
	/**
	 * @var string
	 */
	protected $prefix;

	/**
	 * @var array
	 */
	protected $params = [];

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
			array_get($this->params, 'queue'),
			array_get($this->params, 'class'),
			array_get($this->params, 'payload', [])
		);

		return $job;
	}
}