<?php
/**
 * Posts template
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

<section id="post-<?php the_ID(); ?>" class="page-content">
    <div class="row">
        <article <?php post_class( array( 'small-12', 'medium-9', 'columns' ) ); ?>>

            <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <div class="thumbnail post-thumbnail-container">
                        <?php the_post_thumbnail( 'thumbnail' ); ?>
                    </div>
                </a>
            <?php endif; ?>

            <h1 class="post-title">
                <?php the_title(); ?>
            </h1>

            <div class="post-meta">

                <strong>Date: </strong><?php the_date(); ?><br />

                <?php if ( get_the_terms( get_the_ID(), 'wasentha_artwork_series' ) !== false ) : ?>
                    <strong>Series:</strong> <?php the_terms( get_the_ID(), 'wasentha_artwork_series' ); ?>
                <?php endif; ?>

                <?php if ( ( get_the_terms( get_the_ID(), 'wasentha_artwork_series' ) !== false ) && ( get_the_terms( get_the_ID(), 'wasentha_artwork_category' ) !== false ) ) : ?>
                    &nbsp;/&nbsp;
                <?php endif; ?>

                <?php if ( get_the_terms( get_the_ID(), 'wasentha_artwork_category' ) !== false ) : ?>
                    <strong>Categories:</strong> <?php the_terms( get_the_ID(), 'wasentha_artwork_category' ); ?><br />
                <?php endif; ?>

                <?php if ( get_field( 'artwork_dimensions' ) !== '' ) : ?>
                    <strong>Dimensions:</strong> <?php the_field( 'artwork_dimensions' ); ?>
                <?php endif; ?>

            </div>

            <div class="post-copy">
                <?php the_content(); ?>
            </div>
            
            <?php if ( comments_open() ) : ?>
            
                <div class="post-comments">
                    <?php comments_template(); ?>
                </div>
            
            <?php endif; ?>

        </article>

        <div class="small-12 medium-3 columns">

            <?php dynamic_sidebar( 'main-sidebar' ); ?>

        </div>
    </div>
</section>

<?php
get_footer();