<?php
/**
 * Shows a single piece of Artwork within a loop.
 *
 * @since   0.1.0
 * @package wasentha
 *
 * @global WP_Query $wp_query
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {

    die;

}

if ( has_post_thumbnail() ) : ?>
<div class="media-object-section">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <div class="thumbnail post-thumbnail-container">
            <?php the_post_thumbnail( 'thumbnail' ); ?>
        </div>
    </a>
</div>
<?php endif; ?>

<div class="media-object-section">

    <h3 class="post-title">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
        </a>
    </h3>
    <div class="post-meta">

        <strong>Date: </strong><?php the_time( get_option( 'date_format' ) ); // the_date() only shows the first occurence ?><br />

        <?php if ( get_the_terms( get_the_ID(), 'wasentha_artwork_series' ) !== false ) : ?>
        <strong>Series:</strong> <?php the_terms( get_the_ID(), 'wasentha_artwork_series' ); ?>
        <?php endif; ?>

        <?php if ( ( get_the_terms( get_the_ID(), 'wasentha_artwork_series' ) !== false ) && ( get_the_terms( get_the_ID(), 'wasentha_artwork_material' ) !== false ) ) : ?>
        &nbsp;/&nbsp;
        <?php endif; ?>

        <?php if ( get_the_terms( get_the_ID(), 'wasentha_artwork_material' ) !== false ) : ?>
        <strong>Materials:</strong> <?php the_terms( get_the_ID(), 'wasentha_artwork_material' ); ?><br />
        <?php endif; ?>

        <?php if ( get_field( 'artwork_dimensions' ) !== '' ) : ?>
        <strong>Dimensions:</strong> <?php the_field( 'artwork_dimensions' ); ?>
        <?php endif; ?>

    </div>
    <div class="post-copy">
        <?php the_excerpt(); ?>
    </div>

</div>