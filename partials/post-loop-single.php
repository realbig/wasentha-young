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

<h1 class="post-title">
    <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
    </a>
</h1>

<div class="post-copy">
    <?php the_excerpt(); ?>
</div>