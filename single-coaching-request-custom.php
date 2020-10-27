<?php

get_header();



?>

<div id="main-content">
	<?php while ( have_posts() ): the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
            <div class="entry-content">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <h2>This is a custom template.</h2>

                <?php the_content(); ?>
            </div> <!-- .entry-content -->


            <?php if ( ( comments_open() || get_comments_number() ) && 'on' === et_get_option( 'divi_show_postcomments', 'on' ) ) {
                comments_template( '', true );
            } ?>

        </article> <!-- .et_pb_post -->

		<?php get_sidebar(); ?>


    <?php endwhile; ?>
</div> <!-- #main-content -->

<?php

get_footer();
