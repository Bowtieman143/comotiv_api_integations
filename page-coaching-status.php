<?php
/**
 * Template Name: Coaching Status
 */

get_header();
$user_id = get_current_user_id();
$author_id = get_the_author_meta('ID');
?>

<div id="main-content">

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

                <h1>Welcome to CoMotiv</h1>
				<iframe src="https://ask.comotiv.com/frwd3ld48#contact_email=dennis@lightsoutinteractive.com&contact_name=Dennis%2520Dinsmore" allow="camera; microphone; autoplay; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>                        

                <?php /*
                <h2>Current User ID: <?php echo $user_id; ?></h2>
                <h2>Author ID: <?php echo $author_id; ?></h2>
                */ ?>


				<?php
				/* Query Coaching Requests 
				// args
				$args = array(
					'numberposts'	=> -1,
					'post_type'		=> 'coaching-request',
					'author'		=> $user_id,
				);


				// the query
				$the_query = new WP_Query( $args ); ?>

				<?php if ( $the_query->have_posts() ) : ?>
                    <table class="coaching_grid">
                        <tr>
                            <th>Coaching Request</th>
                            <th>Assigned Coaching Team</th>
                            <th>Last Comment Date</th>
                            <th>Coaching Status</th>
                        </tr>


                        <!-- pagination here -->

                        <!-- the loop -->
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

							<?php //Get Request Fields
							$post_id = get_the_ID();
							$assigned_coaching_team = get_field('assigned_coaching_team');
							$current_status = get_field('current_status');
							$assigned_coach = get_field('assigned_coach');
							$author_id = get_the_author_meta( 'ID' );
							$author_name = get_the_author_meta( 'display_name', $author_id );
							?>


							<?php //Get Request Comments
							$args = array(
								'post_id' => $post_id,
								'orderby' => array('comment_date'),
								'order' => 'DESC',
								'number' => 1
							);
							$comment = get_comments( $args );
							$comment_id = $comment[0]->comment_ID;
							//print_r($comment[0]);
							?>

                            <tr>
                                <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                                <td><?php echo $assigned_coaching_team; ?></td>
                                <td><?php echo get_comment_date( 'D M j Y', $comment_id ); ?></td>
                                <td><?php echo $current_status; ?></td>
                            </tr>


						<?php endwhile; ?>
                        <!-- end of the loop -->

                    </table>

                    <!-- pagination here -->

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
                    <p><?php _e( 'You have no coaching requests at this time.' ); ?></p>
				<?php endif; ?>
				*/ ?>



            <?php /*
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="entry-title main_title"><?php the_title(); ?></h1>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>
            */ ?>

			</div> <!-- #left-area -->
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
