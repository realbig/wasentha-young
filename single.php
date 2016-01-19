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
			<article <?php post_class(); ?>>

				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>

				<div class="post-copy">
					<?php the_content(); ?>
				</div>

			</article>
		</div>
	</section>

<?php
get_footer();