<?php

namespace Arrounded\Queues;

use Arrounded\Queues\Values\JobDescription;

class QueuesTest extends QueuesTestCase
{
	/**
	 * @var Queues
	 */
	protected $queues;

	public function setUp()
	{
		$this->queues = new Queues();
	}

	public function testReturnsAJobDescriptionAfterAPush()
	{
		$job = $this->queues
			->on('foo')
			->uses('Bar')
			->with([
				'foo' => 'bar',
			])
			->push();

		$this->assertInstanceOf(JobDescription::class, $job);
		$this->assertEquals(new JobDescription('foo', 'Bar', [
			'foo' => 'bar'
		]), $job);
	}

	public function testCanPrefixQueueName()
	{
		$this->queues->setPrefix('foo');
		$job = $this->queues
			->on('foo')
			->uses('Bar')
			->push();

		$this->assertInstanceOf(JobDescription::class, $job);
		$this->assertEquals(new JobDescription('foo_foo', 'Bar'), $job);
	}
}