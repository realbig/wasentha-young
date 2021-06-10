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

                    <div class="top-bar">

                        <div class="top-bar-left hide-for-small-only nav-menu">
                            <?php
                            wp_nav_menu( array(
                                'container' => false,
                                'menu' => __( 'Primary Menu', THEME_ID ),
                                'menu_class' => 'dropdown menu',
                                'theme_location' => 'primary-nav',
                                'items_wrap'      => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
                                'fallback_cb' => false,
                                'walker' => new Foundation_Nav_Walker(),
                            ) );
                            ?>
                        </div>

                        <div class="top-bar-left show-for-small-only">

                            <button class="menu-icon" type="button" data-open="offCanvasLeft"></button>

                        </div>

                    </div>
                    
                    <div class="header-logo-wrapper">
                        
                        <?php if ( is_front_page() ) : ?>
                    
                            <img class="header-logo" src="<?php echo get_theme_mod( 'wasentha_logo_image', 'http://placehold.it/1200x312' ); ?>" />
                        
                        <?php else : ?>
                        
                            <div class="header-logo not-home" style="background-image: url('<?php echo get_theme_mod( 'wasentha_logo_image', 'http://placehold.it/1200x312' ); ?>')">
                            </div>
                        
                        <?php endif; ?>
                        
                        <h1>
                            <span class="description"><?php echo get_bloginfo( 'description' ); ?></span>
                        </h1>
                        
                    </div>

                </header>

                <section id="site-content">