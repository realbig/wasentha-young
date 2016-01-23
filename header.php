<?php
/**
 * The theme's header file that appears on EVERY page.
 *
 * @since   0.1.0
 * @package wasentha
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

// Start a session to preserve bucket data
if ( ! isset( $_SESSION ) ) {
    session_start();
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">

        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <!--[if lt IE 9]>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/vendor/js/html5.js"></script>
<![endif]-->

        <?php wp_head(); ?>

    </head>

    <body <?php body_class( 'off-canvas-wrapper' ); ?>>

        <div id="wrapper" class = "off-canvass-wrapper-inner row" data-off-canvas-wrapper>

            <div class="off-canvas position-left nav-menu" id="offCanvasLeft" data-off-canvas>

                <?php
                wp_nav_menu( array(
                    'container' => false,
                    'menu' => __( 'Primary Menu', THEME_ID ),
                    'menu_class' => 'menu',
                    'theme_location' => 'primary-nav',
                    'items_wrap'      => '<ul id="%1$s" class="vertical %2$s">%3$s</ul>',
                    'fallback_cb' => false,
                    'walker' => new Foundation_Nav_Walker(),
                ) );
                ?>

            </div>

            <div class="off-canvas-content" data-off-canvas-content>

                <header id="site-header">

                    <div class="top-bar small-12 medium-3 columns">

                        <div class="top-bar-left hide-for-small-only nav-menu">
                            <?php
                            wp_nav_menu( array(
                                'container' => false,
                                'menu' => __( 'Primary Menu', THEME_ID ),
                                'menu_class' => 'dropdown menu',
                                'theme_location' => 'primary-nav',
                                'items_wrap'      => '<ul id="%1$s" class="vertical %2$s" data-dropdown-menu>%3$s</ul>',
                                'fallback_cb' => false,
                                'walker' => new Foundation_Nav_Walker(),
                            ) );
                            ?>
                        </div>

                        <div class="top-bar-left show-for-small-only">

                            <button class="menu-icon" type="button" data-open="offCanvasLeft"></button>

                        </div>

                    </div>

                    <?php
                    // We need to assign the height of the image based on the number of Top-Level Menu Items. It is a nasty solution, but it works.
                    // Otherwise, we'd need to calculate it via JavaScript. In some ways that's better, but it could make the page "jump" as it loads.
                    $menu_to_count = wp_nav_menu( array(
                        'echo' => false,
                        'theme_location' => 'primary-nav',
                        'depth' => 1,
                    ) );
                    $menu_items = substr_count( $menu_to_count, 'class="menu-item ' );
                    $menu_item_height = 39.375;
                    $padding_top_plus_bottom = 16;
                    
                    $image_height = ( $menu_item_height * $menu_items ) + 16;
                    $image_height = $image_height . 'px';
                    ?>


                    <div class="header-logo small-12 medium-9 columns hide-for-small-only" style="background-image: url('<?php echo get_theme_mod( 'wasentha_logo_image', 'http://placehold.it/1200x312' ); ?>'); height: <?php echo $image_height; ?>;">
                    </div>
                    
                    <img class="header-logo-mobile show-for-small-only small-12" src="<?php echo get_theme_mod( 'wasentha_logo_image', 'http://placehold.it/1200x312' ); ?>" />

                </header>

                <section id="site-content">