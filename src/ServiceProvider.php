<?php

namespace Arrounded\Queues;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(Queues::class, function () {
			$queues = new Queues($this->app['queue.connection']);
			$queues->setPrefix($this->app->environment());

			return $queues;
		});

		$this->app->bind('arrounded.queues', Queues::class);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['arrounded.queues'];
	}
}