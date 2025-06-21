<?php
/**
 * Plugin Unit Test Bootstrap File
 */

// Load Composer autoloader
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Define WordPress tests directory (set via env or fallback to local)
$_tests_dir = getenv( 'WP_TESTS_DIR' ) ?: __DIR__ . '/wordpress-tests-lib';

// Bail early if test library is missing
if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
    echo "Error: WordPress test suite not found in $_tests_dir\n";
    exit(1);
}

// Load WordPress test function definitions
require_once $_tests_dir . '/includes/functions.php';

// Load your plugin manually before WordPress loads
tests_add_filter( 'muplugins_loaded', function () {
    require dirname( __DIR__ ) . '/cleaner-profile.php';
});

// Include additional plugin-specific files (e.g., pagination logic)
require_once dirname( __DIR__ ) . '/includes/pagination.php';

// Boot up the WordPress testing environment
require $_tests_dir . '/includes/bootstrap.php';
