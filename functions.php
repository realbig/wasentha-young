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
    
    $wp_customize->add_setting( 'wasentha_logo_image', array(
            'default'     => 'http://placehold.it/1200x312',
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wasentha_logo_image', array(
        'label'        => __( 'Logo Banner', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'wasentha_logo_image',
    ) ) );
    
    $wp_customize->add_setting( 'home_page_intro_image' , array(
            'default'     => 9,
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'home_page_intro_image', array(
        'label'        => __( 'Intro Image', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'mime_type' => 'image',
        'active_callback' => 'is_front_page',
    ) ) );
    
    $wp_customize->add_setting( 'home_page_intro_paragraph', array(
            'default'     => 'Enter Text in the Customizer',
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_page_intro_paragraph', array(
        'type' => 'textarea',
        'label'        => __( 'Intro Paragraph', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'home_page_intro_paragraph',
        'active_callback' => 'is_front_page',
    ) ) );
    
    $wp_customize->add_setting( 'home_page_workshop_title', array(
            'default'     => 'Workshops',
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_page_workshop_title', array(
        'label'        => __( 'Workshops Title', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'home_page_workshop_title',
        'active_callback' => 'is_front_page',
    ) ) );
    
    $wp_customize->add_setting( 'home_page_exhibits_title', array(
            'default'     => 'Current Exhibits',
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_page_exhibits_title', array(
        'label'        => __( 'Exhibits Title', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'home_page_exhibits_title',
        'active_callback' => 'is_front_page',
    ) ) );
    
    $wp_customize->add_setting( 'wasentha_recent_posts_title', array(
            'default'     => 'Recent Blog Posts',
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wasentha_recent_posts_title', array(
        'label'        => __( 'Recent Posts Title', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'wasentha_recent_posts_title',
        'active_callback' => 'is_front_page',
    ) ) );
    
    $wp_customize->add_setting( 'wasentha_recent_posts_limit' , array(
            'default'     => 5,
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wasentha_recent_posts_limit', array(
        'type' => 'number',
        'label'        => __( 'Number of Recent Posts on the Home Page', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'wasentha_recent_posts_limit',
        'active_callback' => 'is_front_page',
    ) ) );
    
    $wp_customize->add_setting( 'wasentha_footer_columns' , array(
            'default'     => 4,
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wasentha_footer_columns', array(
        'type' => 'number',
        'label'        => __( 'Footer Number of Columns/Widget Areas', THEME_ID ),
        'section'    => 'wasentha_customizer_section',
        'settings'   => 'wasentha_footer_columns',
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
    
    wp_localize_script( THEME_ID, THEME_ID . '_data', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );

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
    
    // Contact Sidebar
    register_sidebar( array(
        'name' => __( 'Contact Sidebar', THEME_ID ),
        'id' => 'contact-sidebar',
        'description' => __( 'This is the Contact sidebar.', THEME_ID ),
    ) );
    
    // Seminars Sidebar
    register_sidebar( array(
        'name' => __( 'Seminars', THEME_ID ),
        'id' => 'seminar-sidebar',
        'description' => __( 'This is the Seminars sidebar.', THEME_ID ),
    ) );
    
    // Presentations Sidebar
    register_sidebar( array(
        'name' => __( 'Presentations', THEME_ID ),
        'id' => 'presentation-sidebar',
        'description' => __( 'This is the Presentations sidebar.', THEME_ID ),
    ) );
    
    // Testimonials Sidebar
    register_sidebar( array(
        'name' => __( 'Footer Testimonials', THEME_ID ),
        'id' => 'footer-testimonials',
        'description' => __( 'This is the Testimonials area in the Footer.', THEME_ID ),
        'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  =>  '</aside>',
        'before_title'  =>  '<h3 class="widget-title">',
        'after_title'   =>  '</h3>',
    ) );
    
    // Footer
    $footer_columns = get_theme_mod( 'wasentha_footer_columns', 4 );
    for ( $index = 0; $index < $footer_columns; $index++ ) {
        register_sidebar(
            array(
                'name'          =>  'Footer ' . ( $index + 1 ),
                'id'            =>  'footer-' . ( $index + 1 ),
                'description'   =>  sprintf( __( 'This is Footer Widget Area %d', THEME_ID ), ( $index + 1 ) ),
                'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  =>  '</aside>',
                'before_title'  =>  '<h3 class="widget-title">',
                'after_title'   =>  '</h3>',
            )
        );
    }

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
        'featured_image'        => _x( 'Art', THEME_ID ),
        'remove_featured_image' => _x( 'Remove art', THEME_ID ),
        'set_featured_image'    => _x( 'Set art', THEME_ID ),
        'use_featured_image'    => _x( 'Use as art', THEME_ID ),
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
 * Creates the Artwork Material Category
 *
 * @since 0.1.0
 */
add_action( 'init', 'register_taxonomy_wasentha_artwork_material' );
function register_taxonomy_wasentha_artwork_material() {

    $labels = array(
        'name' => _x( 'Artwork Material', THEME_ID ),
        'singular_name' => _x( 'Artwork Material', THEME_ID ),
        'search_items' => __( 'Search Artwork Materials', THEME_ID ),
        'popular_items' => __( 'Popular Artwork Materials', THEME_ID ),
        'all_items' => __( 'All Artwork Materials', THEME_ID ),
        'parent_item' => __( 'Parent Artwork Material', THEME_ID ),
        'parent_item_colon' => __( 'Parent Artwork Material:', THEME_ID ),
        'edit_item' => __( 'Edit Artwork Material', THEME_ID ),
        'update_item' => __( 'Update Artwork Material', THEME_ID ),
        'add_new_item' => __( 'Add New Artwork Material', THEME_ID ),
        'new_item_name' => __( 'New Artwork Material Name', THEME_ID ),
        'separate_items_with_commas' => __( 'Separate Artwork Materials with commas', THEME_ID ),
        'add_or_remove_items' => __( 'Add or remove Artwork Materials', THEME_ID ),
        'choose_from_most_used' => __( 'Choose from the most used Artwork Materials', THEME_ID ),
        'not_found' => __( 'No Artwork Materials found.', THEME_ID ),
        'menu_name' => __( 'Artwork Materials', THEME_ID ),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'artwork-type' ),
    );

    register_taxonomy( 'wasentha_artwork_material', 'wasentha_artwork', $args );

}

/**
 * Creates the [wasentha_artwork] shortcode
 *
 * @since 0.1.0
 */
add_shortcode( 'wasentha_artwork', 'wasentha_artwork_shortcode_register' );
function wasentha_artwork_shortcode_register( $atts ) {
    
    if ( is_front_page() ) {
        $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
    }
    else {
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; 
    }
    
    $atts = shortcode_atts(
        array( // a few default values
            'post_type' => 'wasentha_artwork',
            'ignore_sticky_posts' => 1,
            'suppress_filters' => false,
            'post_status' => 'publish',
            'before_item' => '<article class="media-object stack-for-small">',
            'after_item' => '</article>',
            'classes' => '', // Classes for wrapper <div>
            'posts_per_page' => 5,
            'paged' => $paged,
        ),
        $atts,
        'wasentha_artwork'
    );
    
    $out = '';
    $artwork = new WP_Query( $atts );
    
    $paginate_args = array(
        'current' => $paged,
        'prev_text' => __( '&laquo; View Older Artwork', THEME_ID ),
        'next_text' => __( 'View Newer Artwork &raquo;', THEME_ID ),
    );
    
    // Pagination Fix
    global $wp_query;
    $temp_query = $wp_query;
    $wp_query = NULL;
    $wp_query = $artwork;
    
    if ( $artwork->have_posts() ) : 
    
        ob_start();
    
        echo '<div id="wasentha_artwork-shortcode-' . get_the_id() . '"' . ( ( $atts['classes'] !== '' ) ? ' class="' . $atts['classes'] . '"' : '' ) . '>';
    
        while ( $artwork->have_posts() ) :
            $artwork->the_post();
    
                echo $atts['before_item'];
                    include( locate_template( 'partials/wasentha_artwork-loop-single.php' ) );
                echo $atts['after_item'];
    
        endwhile;
    
            echo '<div class="pagination">';
                echo paginate_links( $paginate_args );
            echo '</div>';
    
        echo '</div>';
        
        $out = ob_get_contents();  
        ob_end_clean();
    
        wp_reset_postdata();
    
        // Reset main query object after Pagination is done.
        $wp_query = NULL;
        $wp_query = $temp_query;
    
        return html_entity_decode( $out );
    
    else :
        return 'No Artwork Found';
    endif;

}

/**
 * Creates the [wasentha_post] shortcode
 *
 * @since 0.1.0
 */
add_shortcode( 'wasentha_post', 'wasentha_post_shortcode_register' );
function wasentha_post_shortcode_register( $atts ) {
    
    if ( is_front_page() ) {
        $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
    }
    else {
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; 
    }
    
    $atts = shortcode_atts(
        array( // a few default values
            'post_type' => 'post',
            'ignore_sticky_posts' => 1,
            'suppress_filters' => false,
            'post_status' => 'publish',
            'before_item' => '<article>',
            'after_item' => '</article>',
            'category' => '',
            'classes' => '', // Classes for wrapper <div>
            'posts_per_page' => 5,
            'excerpt' => true,
            'date' => false,
            'title' => '',
            'paged' => $paged,
        ),
        $atts,
        'wasentha_post'
    );
    
    if ( $atts['category'] !== '' ) {
        
        $atts['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'name',
                'terms' => $atts['category'],
            ),
        );
        
    }
    
    $out = '';
    $wasentha_post = new WP_Query( $atts );
    
    $paginate_args = array(
        'current' => $paged,
        'prev_text' => __( '&laquo; View Older Posts', THEME_ID ),
        'next_text' => __( 'View Newer Posts &raquo;', THEME_ID ),
    );

    if ( is_front_page() ) {
        $paginate_args['format'] = 'blog/page/%#%';
    }
    
    // Pagination Fix
    global $wp_query;
    $temp_query = $wp_query;
    $wp_query = NULL;
    $wp_query = $wasentha_post;
    
    if ( $wasentha_post->have_posts() ) : 
    
        ob_start();
    
        echo '<div id="wasentha_post-shortcode-' . get_the_id() . '"' . ( ( $atts['classes'] !== '' ) ? ' class="' . $atts['classes'] . '"' : '' ) . '>';
    
        if ( $atts['title'] !== '' ) {
            ?>
            
            <div class="heading">
                
                <h2><?php echo $atts['title']; ?></h2>

            </div>

            <?php
        }
    
        while ( $wasentha_post->have_posts() ) :
            $wasentha_post->the_post();
    
                // Forcefully add post_class()
                if ( strpos( $atts['before_item'], 'class' ) !== false ) {
                    
                    $atts['before_item'] = preg_replace( '/class\s?=\s?"/i', 'class="' . implode( ' ', get_post_class() ) . ' ', $atts['before_item'] );
                    
                }
                else {
                    
                    $atts['before_item'] = str_replace( '>', ' class="' . implode( ' ', get_post_class() ) . '">', $atts['before_item'] );
                    
                }
    
                echo $atts['before_item'];
                    include( locate_template( 'partials/post-loop-single.php' ) );
                echo $atts['after_item'];
    
        endwhile;
    
            echo '<div class="post pagination">';
                echo paginate_links( $paginate_args );
            echo '</div>';
    
        echo '</div>';
        
        $out = ob_get_contents();  
        ob_end_clean();
    
        wp_reset_postdata();
        
        // Reset main query object after Pagination is done.
        $wp_query = NULL;
        $wp_query = $temp_query;
    
        return html_entity_decode( $out );
    
    else :
    
        if ( $atts['category'] !== '' ) {
            return 'No Posts in the ' . $atts['category'] . ' Category Found';
        }
    
        return 'No Posts Found';
    
    endif;

}

/**
 * Creates the [wasentha_testimonial] shortcode
 *
 * @since 0.1.0
 */
add_shortcode( 'wasentha_testimonial', 'wasentha_testimonial_shortcode_register' );
function wasentha_testimonial_shortcode_register( $atts ) {
    
    $atts = shortcode_atts(
        array( // a few default values
            'post_type' => 'testimonial',
            'ignore_sticky_posts' => 1,
            'suppress_filters' => false,
            'post_status' => 'publish',
            'category' => '',
            'classes' => '', // Classes for wrapper <div>
        ),
        $atts,
        'wasentha_testimonial'
    );
    
    if ( $atts['category'] !== '' ) {
        
        $atts['tax_query'] = array(
            array(
                'taxonomy' => 'testimonial-category',
                'field' => 'name',
                'terms' => $atts['category'],
            ),
        );
        
    }
    
    $out = '';
    $wasentha_testimonial = new WP_Query( $atts );
    
    if ( $wasentha_testimonial->have_posts() ) : 
    
        ob_start();
    
        $classes = $atts['classes'];
        
        $category = '';
        if ( $atts['category'] !== '' ) {
            $category .= ' data-category="' . $atts['category'] . '"';
        }
    
        echo '<div id="wasentha_testimonial-shortcode" class="post-' . get_the_ID() . $classes . '"' . $category . '>';
            ?>
                    <span class="fa fa-spinner fa-spin testimonial-loading"></span>

                    <div class="testimonials-content" style="display: none;">

                        <blockquote class="testimonials-text" itemprop="reviewBody">
                        </blockquote>

                        <cite class="author" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span itemprop="name"></span></cite>
                        
                    </div>
                
            <?php
    
        echo '</div>';
        
        $out = ob_get_contents();  
        ob_end_clean();
    
        wp_reset_postdata();
    
        return html_entity_decode( $out );
    
    else :
    
        if ( $atts['category'] !== '' ) {
            return 'No Testimonials in the ' . $atts['category'] . ' Category Found';
        }
    
        return 'No Testimonials Found';
    
    endif;

}

/*
 * Allows Testimonials to be Random while getting around WP Engine's RAND limitations
 *
 * @since 0.1.0
 */
// The AJAX call is given "get_testimonial" which corresponds with the WordPress Action Hook.
add_action( 'wp_ajax_get_testimonial', 'get_wasentha_testimonial_callback' );
add_action( 'wp_ajax_nopriv_get_testimonial', 'get_wasentha_testimonial_callback' );
function get_wasentha_testimonial_callback() {
    
    global $post;
        
    $atts = array(
        'posts_per_page' => -1,
        'post_type' => 'testimonial',
        'post_status' => 'publish',
    );
    
    if ( isset( $_POST['testimonial_category'] ) && ( $_POST['testimonial_category'] !== '' ) ) {
        
        $atts['tax_query'] = array(
            array(
                'taxonomy' => 'testimonial-category',
                'field' => 'name',
                'terms' => $_POST['testimonial_category'],
            ),
        );
        
    }
    
    $testimonials = get_posts( $atts );
    
    $items = array(); // Create an Array for the JSON
    foreach ( $testimonials as $post ) {
        
        setup_postdata( $post );
        
        $items[] = array(
            'name' => get_the_title(),
            'body' => get_the_content(),
        );
        
    }
    
    wp_reset_postdata();
    
    echo json_encode( $items );
    
    die();
    
}

/*
 * Since WP Smilies load as Images, MailChimp makes them HUGE. For RSS Feeds, let's make sure they are straight text.
 *
 * @since 0.3.0
 */
add_action( 'pre_get_posts', 'remove_wp_smilies_from_feed' );
function remove_wp_smilies_from_feed( $query ) {
    
    if ( $query->is_feed ) {
        remove_filter( 'the_content', 'convert_smilies' );
    }
    
    global $post;
    
    // If Writings Page 
    if ( $post->post_name == 'writing' ) {
        
        add_filter( 'widget_posts_args', 'no_writings_category_on_writing_page' );
        
    }
    
}

/* Exclude Writings Category from Recent Posts on Writings Page
 *
 * @since 0.3.0
 */
function no_writings_category_on_writing_page( $args ) {
    
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'terms' => array( 'Writings' ),
            'field' => 'name',
            'operator' => 'NOT IN',
        )
    );
    
    return $args;
    
}
