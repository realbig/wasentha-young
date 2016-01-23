<?php
/**
 * Artwork Series Taxonomy index page.
 *
 * @since 0.1.0
 * @package wasentha
 *
 * @global WP_Query $wp_query
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

get_header();
?>

<section id="wasentha_artwork-index" class="page-content">
    <div class="row">

        <?php
        if ( have_posts() ) :
        ?><div class="small-12 medium-9 columns"><?php
        while ( have_posts() ) :
        the_post();
        ?>
        <article <?php post_class( array( 'media-object', 'stack-for-small' ) ); ?>>

            <?php if ( has_post_thumbnail() ) : ?>
            <div class="media-object-section">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <div class="thumbnail post-thumbnail-container">
                        <?php the_post_thumbnail( 'thumbnail' ); ?>
                    </div>
                </a>
            </div>
            <?php endif; ?>

            <div class="media-object-section">

                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-meta">
                    
                    <strong>Date: </strong><?php the_time( get_option( 'date_format' ) ); // the_date() only shows the first occurence ?><br />

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
                    <?php the_excerpt(); ?>
                </div>

            </div>

            </article>
            <?php
            endwhile;
            ?></div><?php
        else:
        ?>

        <div class="small-12 medium-9 columns">
            Nothing found.
        </div>

        <?php endif; ?>

        <div class="small-12 medium-3 columns">

            <?php dynamic_sidebar( 'main-sidebar' ); ?>

        </div>

        </div>
        </section>

    <?php
    get_footer();