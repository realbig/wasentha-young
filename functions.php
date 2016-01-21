<?php
/**
 * The theme's functions file that loads on EVERY page, used for uniform functionality.
 *
 * @since   0.1.0
 * @package wasentha
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

// Make sure PHP version is correct
if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
    wp_die( 'ERROR in Wasentha theme: PHP version 5.3 or greater is required.' );
}

// Make sure no theme constants are already defined (realistically, there should be no conflicts)
if ( defined( 'THEME_VERSION' ) || defined( 'THEME_ID' ) || isset( $wasentha_fonts ) ) {
    wp_die( 'ERROR in Wasentha theme: There is a conflicting constant. Please either find the conflict or rename the constant.' );
}

/**
 * The theme's current version (make sure to keep this up to date!)
 */
define( 'THEME_VERSION', '0.1.0' );

/**
 * The theme's ID (used in handlers).
 */
define( 'THEME_ID', 'wasentha_theme' );

/**
 * Fonts for the theme. Must be hosted font (Google fonts for example).
 */
$wasentha_fonts = array(
    'Font Awesome' => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
);

/**
 * Setup theme properties and stuff.
 *
 * @since 0.1.0
 */
add_action( 'after_setup_theme', function () {

    // Image sizes
    if ( ! empty( $wasentha_image_sizes ) ) {

        foreach ( $wasentha_image_sizes as $ID => $size ) {
            add_image_size( $ID, $size['width'], $size['height'], $size['crop'] );
        }

        add_filter( 'image_size_names_choose', '_meesdist_add_image_sizes' );
    }

    // Add theme support
    require_once __DIR__ . '/includes/theme-support.php';

    require_once __DIR__ . '/includes/class-foundation_nav_walker.php';

    // Allow shortcodes in text widget
    add_filter( 'widget_text', 'do_shortcode' );

} );

/**
 * Adds support for custom image sizes.
 *
 * @since 0.1.0
 *
 * @param $sizes array The existing image sizes.
 *
 * @return array The new image sizes.
 */
function _meesdist_add_image_sizes( $sizes ) {

    global $wasentha_image_sizes;

    $new_sizes = array();
    foreach ( $wasentha_image_sizes as $ID => $size ) {
        $new_sizes[ $ID ] = $size['title'];
    }

    return array_merge( $sizes, $new_sizes );
}

/**
 * Register theme files.
 *
 * @since 0.1.0
 */
add_action( 'init', function () {

    global $wasentha_fonts;

    // Theme styles
    wp_register_style(
        THEME_ID,
        get_template_directory_uri() . '/style.css',
        null,
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );

    // Theme script
    wp_register_script(
        THEME_ID,
        get_template_directory_uri() . '/script.js',
        array( 'jquery' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
        true
    );

    // Theme fonts
    if ( ! empty( $wasentha_fonts ) ) {
        foreach ( $wasentha_fonts as $ID => $link ) {
            wp_register_style(
                THEME_ID . "-font-$ID",
                $link
            );
        }
    }

} );

/**
 * Register sidebars.
 *
 * @since 0.1.0
 */
add_action( 'widgets_init', function () {

    // Main Sidebar
    register_sidebar( array(
        'name' => __( 'Main Sidebar', THEME_ID ),
        'id' => 'main-sidebar',
        'description' => __( 'This is the default sidebar that appears.', THEME_ID ),
    ) );
    
} );

/**
 * Adds a favicon.
 *
 * @since 0.1.0
 */
add_action( 'wp_head', '_wasentha_favicon' );
add_action( 'admin_head', '_wasentha_favicon' );
function _wasentha_favicon() {

    if ( ! file_exists( get_stylesheet_directory() . '/assets/images/favicon.ico' ) ) {
        return;
    }
?>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() . '/assets/images/favicon.ico'; ?>" />
<?php
}

/**
 * Enqueue theme files.
 *
 * @since 0.1.0
 */
add_action( 'wp_enqueue_scripts', function () {

    global $wasentha_fonts;

    // Theme styles
    wp_enqueue_style( THEME_ID );

    // Theme script
    wp_enqueue_script( THEME_ID );

    // Theme fonts
    if ( ! empty( $wasentha_fonts ) ) {
        foreach ( $wasentha_fonts as $ID => $link ) {
            wp_enqueue_style( THEME_ID . "-font-$ID" );
        }
    }

} );

/**
 * Register nav menus.
 *
 * @since 0.1.0
 */
add_action( 'after_setup_theme', function () {

    register_nav_menu( 'primary-nav', 'Primary Menu' );

} );

require_once __DIR__ . '/includes/theme-functions.php';