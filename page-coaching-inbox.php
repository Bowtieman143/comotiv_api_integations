<?php
/**
 * Template Name: Coaching Inbox
 */

get_header();
$user_id = get_current_user_id();
?>

<div id="main-content">

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

                <?php /* <h2>Current User ID: <?php echo $user_id; ?></h2>*/ ?>

                <h1>Coaching Inbox</h1>
                <hr><br>

                <h2>Assigned Coaching Requests</h2>
				<?php
				$args = array(
					'numberposts'	=> -1,
					'post_type'		=> 'coaching-request',
					'meta_key'		=> 'assigned_coach',
					'meta_value'	=> $user_id
				);
				$the_query = new WP_Query( $args ); ?>

				<?php if ( $the_query->have_posts() ) : ?>
                    <ul>
                    <!-- pagination here -->

                    <!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <?php
						    $assigned_coach = get_field('assigned_coach');
						?>

                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

					<?php endwhile; ?>
                    <!-- end of the loop -->

                    </ul>

                    <!-- pagination here -->

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
                    <p><?php _e( 'You have no assigned coaching requests at this time.' ); ?></p>
				<?php endif; ?>
                <br><hr><br>


                <h2>All Coaching Requests</h2>
				<?php
				$args = array(
					'numberposts'	=> -1,
					'post_type'		=> 'coaching-request',
					//'meta_key'		=> 'current_status',
					//'meta_value'	=> 'Waiting for Assignment',
				);
				$the_query = new WP_Query( $args ); ?>

				<?php if ( $the_query->have_posts() ) : ?>

                    <!-- pagination here -->

                    <!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

						<?php
						$assigned_coach = get_field('assigned_coach');
						?>

                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>


					<?php endwhile; ?>
                    <!-- end of the loop -->

                    <!-- pagination here -->

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
                    <p><?php _e( 'There are no un-assigned coaching requests at this time.' ); ?></p>
				<?php endif; ?>



			</div> <!-- #left-area -->
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
