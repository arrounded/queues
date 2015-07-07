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
	 * @var int
	 */
	protected $delay = 0;

	/**
	 * @param $queue
	 * @param $class
	 * @param array $payload
	 * @param int $delay
	 */
	public function __construct($queue, $class, array $payload = [], $delay = 0)
	{
		$this->queue = $queue;
		$this->class = $class;
		$this->payload = $payload;
		$this->delay = $delay;
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

	/**
	 * @return bool
	 */
	public function isDelayed()
	{
		return $this->delay > 0;
	}

	/**
	 * @return int
	 */
	public function getDelay()
	{
		return $this->delay;
	}
}