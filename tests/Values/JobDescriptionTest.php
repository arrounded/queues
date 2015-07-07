<?php

namespace Arrounded\Queues\Values;

use Arrounded\Queues\QueuesTestCase;

class JobDescriptionTest extends QueuesTestCase
{
	public function testCanRetrieveJobInfo()
	{
		$job = new JobDescription('foo', 'Foo', ['foo' => 'bar']);
		$this->assertEquals('foo', $job->getQueue());
		$this->assertEquals('Foo', $job->getClass());
		$this->assertEquals(['foo' => 'bar'], $job->getPayload());
	}
}