<?php

namespace Arrounded\Queues\Values;

class JobDescription
{
	/**
	 * @var array
	 */
	protected $payload = [];

	/**
	 * @var string
	 */
	protected $queue;

	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @param string $queue
	 * @param string $class
	 * @param array $payload
	 */
	public function __construct($queue, $class, array $payload = [])
	{
		$this->queue = $queue;
		$this->class = $class;
		$this->payload = $payload;
	}

	/**
	 * @return string
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * @return string
	 */
	public function getQueue()
	{
		return $this->queue;
	}

	/**
	 * @return array
	 */
	public function getPayload()
	{
		return $this->payload;
	}
}