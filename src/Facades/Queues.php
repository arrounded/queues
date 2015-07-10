<?php

namespace Arrounded\Queues\Facades;

use Illuminate\Support\Facades\Facade;

class Queues extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'arrounded.queues';
	}

}