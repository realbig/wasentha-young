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

<div id="intro-message" class="row collapse align-center">
    <div class="media-object stack-for-small">

        <div class="media-object-section">
            <?php echo wp_get_attachment_image( get_theme_mod( 'home_page_intro_image', 9 ), 'medium', false, array( 'class' => 'thumbnail' ) ); ?>
        </div>

        <div class="media-object-section">
            <?php echo apply_filters( 'the_content', get_theme_mod( 'home_page_intro_paragraph', 'Enter Text in the Customizer' ) ); ?>
        </div>

    </div>
</div>

<section id="page-<?php the_ID(); ?>" <?php body_class( array( 'page-content' ) ); ?>>

    <div class="row">

        <div class="small-12 medium-9 columns">

            <div class="page-copy">
                <?php the_content(); ?>
            </div>

            <?php if ( comments_open() ) : ?>

                <div class="page-comments">
                    <?php comments_template(); ?>
                </div>

            <?php endif; ?>

        </div>

        <div class="small-12 medium-3 columns sidebar">

            <?php dynamic_sidebar( 'main-sidebar' ); ?>

        </div>

    </div>
</section>

<?php
get_footer();