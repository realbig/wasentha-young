<?php
/**
 * Front Page template
 *
 * @since 0.1.0
 * @package wasentha
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

get_header();

the_post();
?>

<div id="intro-message" class="row collapse">
    <div class="media-object stack-for-small">

        <div class="media-object-section">
            <?php echo wp_get_attachment_image( get_theme_mod( 'home_page_intro_image', 9 ), 'thumbnail', false, array( 'class' => 'thumbnail' ) ); ?>
        </div>

        <div class="media-object-section">
            <?php echo apply_filters( 'the_content', get_theme_mod( 'home_page_intro_paragraph', 'Enter Text in the Customizer' ) ); ?>
        </div>

    </div>
</div>

<section id="page-<?php the_ID(); ?>" <?php body_class( array( 'page-content' ) ); ?>>

    <div class="row">

        <div class="small-12 columns">

            <div class="page-copy">
                <?php the_content(); ?>
            </div>

        </div>

    </div>
</section>

<section id="workshops-exhibits" class="row collapse">

    <div class="small-12 medium-6 columns valign-center text-center">
        
        <h2><?php echo get_theme_mod( 'home_page_workshop_title', 'Workshops' ); ?></h2>
        <?php echo apply_filters( 'the_content', get_theme_mod( 'home_page_workshop_content', 'Enter Text in the Customizer' ) ); ?>
        
    </div>
    <div class="small-12 medium-6 columns valign-center text-center">
        
        <h2><?php echo get_theme_mod( 'home_page_exhibits_title', 'Current Exhibits' ); ?></h2>
        <?php echo apply_filters( 'the_content', get_theme_mod( 'home_page_exhibits_content', 'Enter Text in the Customizer' ) ); ?>
        
    </div>

</section>

<section id="recent-posts">
    <?php echo do_shortcode( get_theme_mod( 'home_page_recent_posts', '[wasentha_post excerpt=false date=true classes="home-blogs-list" title="Recent Blog Posts"]' ) ); ?>
</section>

<?php
get_footer();