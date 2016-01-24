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
    
    // Add Customizer Controls
    add_action( 'customize_register', 'wasentha_customize_register' );

    require_once __DIR__ . '/includes/class-foundation_nav_walker.php';

    // Allow shortcodes in text widget
    add_filter( 'widget_text', 'do_shortcode' );

} );

/**
 * Adds custom Customizer Controls.
 *
 * @since 0.1.0
 */
function wasentha_customize_register( $wp_customize ) {
    
    // General Theme Options
    $wp_customize->add_section( 'wasentha_customizer_section' , array(
            'title'      => __( 'Wasentha Young Settings', THEME_ID ),
            'priority'   => 30,
        ) 
    );
    
    $wp_customize->add_setting( 'wasentha_logo_image' , array(
            'default'     => 'http://placehold.it/1200x312',
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wasentha_logo_image', array(
        'label'        => __( 'Logo Banner', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'wasentha_logo_image',
    ) ) );
    
}

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

/**
 * Creates the Artwork CPT
 *
 * @since 0.1.0
 */
add_action( 'init', 'register_cpt_wasentha_artwork' );
function register_cpt_wasentha_artwork() {

    $labels = array(
        'name' => _x( 'Artwork', THEME_ID ),
        'all_items' => __( 'All Artwork', THEME_ID ),
        'singular_name' => _x( 'Artwork', THEME_ID ),
        'add_new' => _x( 'Add New Artwork', THEME_ID ),
        'add_new_item' => _x( 'Add New Artwork', THEME_ID ),
        'edit_item' => _x( 'Edit Artwork', THEME_ID ),
        'new_item' => _x( 'New Artwork', THEME_ID ),
        'view_item' => _x( 'View Artwork', THEME_ID ),
        'search_items' => _x( 'Search Artwork', THEME_ID ),
        'not_found' => _x( 'No Artwork found', THEME_ID ),
        'not_found_in_trash' => _x( 'No Artwork found in Trash', THEME_ID ),
        'parent_item_colon' => _x( 'Parent Artwork:', THEME_ID ),
        'menu_name' => _x( 'Artwork', THEME_ID ),
    );
    $args = array(
        'labels' => $labels,
        'menu_icon' => 'dashicons-art',
        'hierarchical' => false,
        'description' => 'artwork',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array(
            'slug' => 'artwork',
            'with_front' => false,
            'feeds' => false,
            'pages' => true
        ),
        'capability_type' => 'post',
        /*
        'capability_type' => 'artwork',
        'capabilities' => array(
            // Singular
            'edit_post'	=>	'edit_artwork',
            'read_post'	=>	'read_artwork',
            'delete_post'	=>	'delete_artwork',
            // Plural
            'edit_posts'	=>	'edit_artworks',
            'edit_others_posts'	=>	'edit_others_artworks',
            'publish_posts'	=>	'publish_artworks',
            'read_private_posts'	=>	'read_private_artworks',
            'delete_posts'	=>	'delete_artworks',
            'delete_private_posts'	=>	'delete_private_artworks',
            'delete_published_posts'	=>	'delete_published_artworks',
            'delete_others_posts'	=>	'delete_others_artworks',
            'edit_private_posts'	=>	'edit_private_artworks',
            'edit_published_posts'	=>	'edit_published_artworks',
        ),
		*/
    );

    register_post_type( 'wasentha_artwork', $args );

}

/**
 * Creates the Artwork Series Category
 *
 * @since 0.1.0
 */
add_action( 'init', 'register_taxonomy_wasentha_artwork_series' );
function register_taxonomy_wasentha_artwork_series() {

    $labels = array(
        'name' => _x( 'Series', THEME_ID ),
        'singular_name' => _x( 'Artwork Series', THEME_ID ),
        'search_items' => __( 'Search Series', THEME_ID ),
        'popular_items' => __( 'Popular Series', THEME_ID ),
        'all_items' => __( 'All Series', THEME_ID ),
        'parent_item' => __( 'Parent Series', THEME_ID ),
        'parent_item_colon' => __( 'Parent Series:', THEME_ID ),
        'edit_item' => __( 'Edit Series', THEME_ID ),
        'update_item' => __( 'Update Series', THEME_ID ),
        'add_new_item' => __( 'Add New Series', THEME_ID ),
        'new_item_name' => __( 'New Series Name', THEME_ID ),
        'separate_items_with_commas' => __( 'Separate Series with commas', THEME_ID ),
        'add_or_remove_items' => __( 'Add or remove Series', THEME_ID ),
        'choose_from_most_used' => __( 'Choose from the most used Series', THEME_ID ),
        'not_found' => __( 'No Series found.', THEME_ID ),
        'menu_name' => __( 'Artwork Series', THEME_ID ),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'artwork-series' ),
    );

    register_taxonomy( 'wasentha_artwork_series', 'wasentha_artwork', $args );

}

/**
 * Creates the Artwork Type Category
 *
 * @since 0.1.0
 */
add_action( 'init', 'register_taxonomy_wasentha_artwork_category' );
function register_taxonomy_wasentha_artwork_category() {

    $labels = array(
        'name' => _x( 'Artwork Type', THEME_ID ),
        'singular_name' => _x( 'Artwork Category', THEME_ID ),
        'search_items' => __( 'Search Artwork Categories', THEME_ID ),
        'popular_items' => __( 'Popular Artwork Categories', THEME_ID ),
        'all_items' => __( 'All Artwork Categories', THEME_ID ),
        'parent_item' => __( 'Parent Artwork Category', THEME_ID ),
        'parent_item_colon' => __( 'Parent Artwork Category:', THEME_ID ),
        'edit_item' => __( 'Edit Artwork Category', THEME_ID ),
        'update_item' => __( 'Update Artwork Category', THEME_ID ),
        'add_new_item' => __( 'Add New Artwork Category', THEME_ID ),
        'new_item_name' => __( 'New Artwork Category Name', THEME_ID ),
        'separate_items_with_commas' => __( 'Separate Artwork Categories with commas', THEME_ID ),
        'add_or_remove_items' => __( 'Add or remove Artwork Categories', THEME_ID ),
        'choose_from_most_used' => __( 'Choose from the most used Artwork Categories', THEME_ID ),
        'not_found' => __( 'No Artwork Categories found.', THEME_ID ),
        'menu_name' => __( 'Artwork Categories', THEME_ID ),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'artwork-type' ),
    );

    register_taxonomy( 'wasentha_artwork_category', 'wasentha_artwork', $args );

}

/**
 * Creates the [wasentha_artwork] shortcode
 *
 * @since 0.1.0
 */
add_shortcode( 'wasentha_artwork', 'wasentha_artwork_shortcode_register' );
function wasentha_artwork_shortcode_register( $atts ) {
    
    $atts = shortcode_atts(
        array( // a few default values
            'post_type' => 'wasentha_artwork',
            'ignore_sticky_posts' => 1,
            'suppress_filters' => false,
            'post_status' => 'publish',
            'before_item' => '<article class="media-object stack-for-small">',
            'after_item' => '</article>',
            'classes' => '', // Classes for wrapper <div>
        ),
        $atts,
        'wasentha_artwork'
    );
    
    $out = '';
    $artwork = new WP_Query( $atts );
    
    if ( $artwork->have_posts() ) : 
    
        ob_start();
    
        echo '<div id="wasentha_artwork-shortcode"' . ( ( $atts['classes'] !== '' ) ? ' class="' . $atts['classes'] . '"' : '' ) . '>';
    
        while ( $artwork->have_posts() ) :
            $artwork->the_post();
    
                echo $atts['before_item'];
                    get_template_part( 'partials/wasentha_artwork', 'loop-single' );
                echo $atts['after_item'];
    
        endwhile;
    
        echo '</div>';
        
        $out = ob_get_contents();  
        ob_end_clean();
    
        return html_entity_decode( $out );
    
    else :
        return 'No Artwork Found';
    endif;

}