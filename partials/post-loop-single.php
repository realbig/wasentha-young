<?php
/**
 * Shows a single Post within a loop.
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

?>


<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    
    <h1 class="post-title">
        
        <?php the_title(); ?>
        
    </h1>
        
    <?php if ( strtolower( $atts['date'] ) === "true" ) : ?>

        <?php the_time( 'm/d/Y' ); // the_date() only shows the first occurence ?>

    <?php endif; ?>
        
</a>

<?php // WordPress likes to treat it as a String even when I enter it as a Bool ?>
<?php if ( strtolower( $atts['excerpt'] ) !== "false" ) : ?>

<div class="post-copy">
    <?php the_excerpt(); ?>
</div>

<?php endif; ?>