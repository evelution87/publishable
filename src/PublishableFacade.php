<?php

namespace Evelution\Publishable;

use Illuminate\Support\Facades\Facade;

class PublishableFacade extends Facade {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'publishable';
	}
}
