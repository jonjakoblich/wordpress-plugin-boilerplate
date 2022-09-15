<?php

namespace ExamplePlugin;

use ExamplePlugin\Interfaces\Hookable;

/**
 * Main plugin class.
 */
final class ExamplePlugin {
	/**
	 * Class instances.
	 */
	private $instances = [];

	/**
	 * The single instance of the class.
	 */
	protected static $_instance = null;

	/**
	 * Main ExamplePlugin instance.
	 * 
	 * @see ExamplePlugin()
	 * @return ExamplePlugin - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Get a Hookable instance.
	 */
	public function get_instance( string $key ) : Hookable {
		return $this->instances[$key];
	}

	/**
	 * Main method for running the plugin.
	 */
	public function run() {
		$this->create_instances();
		$this->register_hooks();
	}

	private function create_instances() {
		// $this->instances['project_post_type'] = new PostTypes\ProjectPostType();
	}

	private function register_hooks() {
		foreach ( $this->get_hookable_instances() as $instance ) {
            $instance->register_hooks();
        }
	}

	private function get_hookable_instances() {
        return array_filter( $this->instances, function( $instance ) {
			return $instance instanceof Hookable;
		} );
    }
}
