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
            <?php echo wp_get_attachment_image( get_theme_mod( 'home_page_intro_image', 9 ), 'medium', false, array( 'class' => 'thumbnail' ) ); ?>
        </div>

        <div class="media-object-section">
            <h1 class="title"><?php echo get_bloginfo( 'name' ); ?></h1>
            <?php echo apply_filters( 'the_content', get_theme_mod( 'home_page_intro_paragraph', 'Enter Text in the Customizer' ) ); ?>
        </div>

    </div>
</div>
            
<?php if ( have_rows( 'wasentha_slides' ) ) : ?>

    <section id="home-slider" class="row collapse realbig-slider-container">
        <div class="realbig-slider">

            <div class="inner">

                <?php

                    $first = true;
                    $index = 0;

                    while ( have_rows( 'wasentha_slides' ) ) : the_row();
                    ?>

                        <?php 
                            $photo = get_sub_field( 'photo' );
                            $url = get_sub_field( 'button_link' );

                            // If the user forgot a protocol, we need to add it
                            $has_http = preg_match_all( '/(http)?(s)?(:)?(\/\/)/', $url, $matches );

                            if ( $has_http == 0 ) {

                                $url = '//' . $url;

                            }

                            $image_alignment = array(
                                'top-left' => '0% 0%',
                                'top-center' => '50% 0%',
                                'top-right' => '100% 0%',
                                'center-left' => '0% 50%',
                                'center-center' => '50% 50%',
                                'center-right' => '100% 50%',
                                'bottom-left' => '0% 100%',
                                'bottom-center' => '50% 100%',
                                'bottom-right' => '100% 100%',
                            );

                        ?>

                        <div class="slide<?php echo ( ( $first === true ) ? ' active' : '' ); ?>">

                            <?php if ( ( $index % 2 ) > 0 ) : ?>

                            <div class="small-6 columns image" style="background-image: url( '<?php echo $photo['sizes']['medium']; ?> '); background-position: <?php echo $image_alignment[ get_sub_field( 'image_alignment' ) ]; ?>">
                            </div>

                            <?php endif; ?>

                            <div class="small-6 columns text">
                                <h2><?php echo get_sub_field( 'descriptor' ); ?></h2>
                                <a href="<?php echo $url; ?>" class="button"><?php echo get_sub_field( 'button_text' ); ?></a>
                            </div>

                            <?php if ( ( $index % 2 ) == 0 ) : ?>

                            <div class="small-6 columns image" style="background-image: url( '<?php echo $photo['sizes']['medium']; ?> '); background-position: <?php echo $image_alignment[ get_sub_field( 'image_alignment' ) ]; ?>">
                            </div>

                            <?php endif; ?>

                        </div>

                    <?php

                        $first = false;
                        $index++;

                    endwhile;
                ?>

            </div>

            <div class="arrow arrow-left"></div>
            <div class="arrow arrow-right"></div>

            <ul class="indicators"></ul>

        </div>
    </section>

<?php endif; ?>

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
        <?php dynamic_sidebar( 'seminar-sidebar' ); ?>
        
    </div>
    <div class="small-12 medium-6 columns valign-center text-center">
        
        <h2><?php echo get_theme_mod( 'home_page_exhibits_title', 'Current Exhibits' ); ?></h2>
        <?php dynamic_sidebar( 'presentation-sidebar' ); ?>
        
    </div>

</section>

<section id="recent-posts">
    <?php echo do_shortcode( '[wasentha_post excerpt=true date=true classes="home-blogs-list" title="' . get_theme_mod( 'wasentha_recent_posts_title', 'Recent Blog Posts' ) . '" posts_per_page=' . get_theme_mod( 'wasentha_recent_posts_limit', 5 ) . ']' ); ?>
</section>

<?php
get_footer();