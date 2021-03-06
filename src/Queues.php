<?php

namespace Arrounded\Queues;

use Arrounded\Queues\Values\JobDescription;
use Illuminate\Contracts\Queue\Queue;

class Queues
{
    const PRIORITY_HIGH = 'high';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_LOW = 'low';

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $priority = self::PRIORITY_NORMAL;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var
     */
    protected $disabled = false;

    /**
     * @param Queue $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @param bool|true $value
     *
     * @return $this
     */
    public function disabled($value = true)
    {
        $this->disabled = $value;

        return $this;
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
    public function priority($priority = self::PRIORITY_NORMAL)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param $seconds
     *
     * @return $this
     */
    public function delay($seconds)
    {
        $this->params['delay'] = $seconds;

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
            array_get($this->params, 'payload', []),
            array_get($this->params, 'delay', 0)
        );

        $this->queue($job);

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

    /**
     * @param JobDescription $job
     *
     * @return void
     */
    protected function queue(JobDescription $job)
    {
        if ($this->disabled) {
            return;
        }
        
        if ($job->isDelayed()) {
            return $this->queue->later($job->getDelay(), $job->getClass(), $job->getPayload(), $job->getQueue());
        }

        return $this->queue->push($job->getClass(), $job->getPayload(), $job->getQueue());
    }
}
