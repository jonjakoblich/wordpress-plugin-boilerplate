<?php
/**
 * Plugin Name: Example Plugin
 * Description: Example Plugin core plugin.
 * Version:     1.0.0
 * Author:      Jon Jakoblich
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

 
/**
 * Plugin Activation
 */
register_activation_hook( __FILE__, function() {
    // Optionally add code to run on plugin activation
});


/**
 * Plugin Deactivation
 */
register_deactivation_hook( __FILE__, function() {
    // Optionally add code to run on plugin deactivation
});


add_action( 'plugins_loaded', function() {
    $autoload = plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

    $dependencies = [
        'Composer autoload files' => is_readable( $autoload ),
        // 'WPGraphQL' => class_exists('WPGraphQL'),
    ];

    $missing_dependencies = array_keys( array_diff( $dependencies, array_filter( $dependencies ) ) );

    $display_admin_notice = function() use ( $missing_dependencies ) {
        ?>
        <div class="notice notice-error">
            <p>The Example Plugin core plugin can't be loaded because these dependencies are missing:</p>
            <ul>
                <?php foreach ( $missing_dependencies as $missing_dependency ) : ?>
                    <li><?php echo esc_html( $missing_dependency ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    };

    // If dependencies are missing, display admin notice and return early.
    if ( $missing_dependencies ) {
        add_action( 'admin_notices', $display_admin_notice );
        add_action( 'network_admin_notices', $display_admin_notice ); // Needed for multisite only.

        return;
    }

    // Optional:
    // define( 'EXAMPLE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    // define( 'EXAMPLE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

    require_once $autoload;

    function ExamplePLugin() {
        return ExamplePLugin\ExamplePLugin::instance();
    }

    ExamplePlugin()->run();
} );
