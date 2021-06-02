<?php

namespace Evelution\Publishable;

use Illuminate\Support\ServiceProvider;

class PublishableServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 */
	public function boot() {
	
	}
	
	/**
	 * Register the application services.
	 */
	public function register() {
		// Register the main class to use with the facade
		$this->app->singleton( 'publishable', function() {
			return new Publishable;
		} );
	}
}
