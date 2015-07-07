<?php

namespace Arrounded\Queues;

use Arrounded\Queues\Values\JobDescription;
use Mockery;
use Mockery\MockInterface;
use Illuminate\Contracts\Queue\Queue;

class QueuesTest extends QueuesTestCase
{
	/**
	 * @var Queues
	 */
	protected $queues;

	/**
	 * @var MockInterface;
	 */
	protected $connection;

	public function setUp()
	{
		$this->connection = Mockery::mock(Queue::class);

		$this->queues = new Queues($this->connection);
	}

	public function testReturnsAJobDescriptionAfterAPush()
	{
		$payload = [
			'foo' => 'bar',
		];

		$this->connection->shouldReceive('push')->with('Bar', $payload, 'foo_normal');

		$job = $this->queues
			->on('foo')
			->uses('Bar')
			->with($payload)
			->push();

		$this->assertInstanceOf(JobDescription::class, $job);
		$this->assertEquals(new JobDescription('foo_normal', 'Bar', $payload), $job);
	}

	public function testCanPrefixQueueName()
	{
		$this->connection->shouldReceive('push')->with('Bar', [], 'foo_foo_normal');

		$this->queues->setPrefix('foo');
		$job = $this->queues
			->on('foo')
			->uses('Bar')
			->push();

		$this->assertInstanceOf(JobDescription::class, $job);
		$this->assertEquals(new JobDescription('foo_foo_normal', 'Bar'), $job);
	}

	public function testCanPrioritizeJobs()
	{
		$this->connection->shouldReceive('push')->with('Bar', [], 'foo_foo_high');

		$this->queues->setPrefix('foo');
		$job = $this->queues
			->on('foo')
			->uses('Bar')
			->priority(Queues::PRIORITY_HIGH)
			->push();

		$this->assertInstanceOf(JobDescription::class, $job);
		$this->assertEquals(new JobDescription('foo_foo_high', 'Bar'), $job);
	}
}