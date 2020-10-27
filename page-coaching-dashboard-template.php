<?php
/**
 * Template Name: Coaching Dashboard
 */

get_header();
$user_id = get_current_user_id();
?>

<div id="main-content">

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

                <h1>Coaching Dashboard</h1>
                <hr><br>

                <?php /* Assigned Coaching Requests - WPQuery */ ?>
                <h2>Assigned Coaching Requests</h2>
				<?php
				$args = array(
					'numberposts'	=> -1,
					'post_type'		=> 'coaching-request',
					'meta_key'		=> 'assigned_coaching_team',
                    'meta_compare' => '!=',
                    'meta_value'	=> "unassigned"
                    
				);
				$the_query = new WP_Query( $args ); ?>

				<?php if ( $the_query->have_posts() ) : ?>
                    <table class="coaching_grid">
                        <tr>
                            <th>Coaching Request</th>
                            <th>Customer</th>
                            <th>Assigned Coaching Team</th>
                            <th>Last Comment Date</th>
                            <th>Time Status</th>
                        </tr>


                    <!-- pagination here -->

                    <!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                        <?php // Get Request Fields
                            $post_id = get_the_ID();
						    $assigned_coaching_team = get_field('assigned_coaching_team');
                            $assigned_coach = get_field('assigned_coach');
						    $author_id = get_the_author_meta( 'ID' );
						    $author_name = get_the_author_meta( 'display_name', $author_id );
						?>


						<?php // Get Request Comments
                            $args = array(
                                'post_id' => $post_id,
                                'orderby' => array('comment_date'),
                                'order' => 'DESC',
                                'number' => 1
                            );
                            $comment = get_comments( $args );
                            $comment_id = $comment[0]->comment_ID;
                            $comment_date_formatted = get_comment_date('D M j Y g:i a', $comment_id);
                            
                            $comment_date_timestamp = get_comment_date('U', $comment_id);

                            $current_time = current_time( 'timestamp' );
                            $late_time = (($comment_date_timestamp) + (15 * 60 * 1000));
                            $time_status = "";

                            if ($current_time > $late_time) {
                                $time_status = "LATE!";
                            }
                            
                            //$((timestamp - 5 * 60 * 1000))
                            //print_r($comment[0]);
						?>

                        <tr>
                            <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                            <td><?php echo $author_name; ?></td>
                            <td><?php echo $assigned_coaching_team; ?></td>
                            <td><?php echo $comment_date_formatted; ?></td>
                            <td>                            
                                <?php echo $time_status; ?>                                                    
                            </td>
                        </tr>


					<?php endwhile; ?>
                    <!-- end of the loop -->

                    </table>

                    <!-- pagination here -->

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
                    <p><?php _e( 'Sorry! There are no coaching requests at this time.' ); ?></p>
				<?php endif; ?>
                <br><br>
                


                <?php /* Assigned Coaching Requests - WPQuery */ ?>
                <h2>Un-Assigned Coaching Requests</h2>
				<?php
				$args = array(
					'numberposts'	=> -1,
					'post_type'		=> 'coaching-request',
					'meta_key'		=> 'assigned_coaching_team',            
                    'meta_value'	=> "unassigned"
                    
				);
				$the_query = new WP_Query( $args ); ?>

				<?php if ( $the_query->have_posts() ) : ?>
                    <table class="coaching_grid">
                        <tr>
                            <th>Coaching Request</th>
                            <th>Customer</th>
                            <th>Assigned Coaching Team</th>
                            <th>Last Comment Date</th>
                        </tr>


                    <!-- pagination here -->

                    <!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                        <?php // Get Request Fields
                            $post_id = get_the_ID();
						    $assigned_coaching_team = get_field('assigned_coaching_team');
                            $assigned_coach = get_field('assigned_coach');
						    $author_id = get_the_author_meta( 'ID' );
						    $author_name = get_the_author_meta( 'display_name', $author_id );
						?>


						<?php // Get Request Comments
                            $args = array(
                                'post_id' => $post_id,
                                'orderby' => array('comment_date'),
                                'order' => 'DESC',
                                'number' => 1
                            );
                            $comment = get_comments( $args );
                            $comment_id = $comment[0]->comment_ID;
                            $comment_date = get_comment_date('D M j Y', $comment_id);
                            //print_r($comment[0]);


						?>

                        <tr>
                            <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                            <td><?php echo $author_name; ?></td>
                            <td><?php echo $assigned_coaching_team; ?></td>
                            <td><?php echo $comment_date; ?></td>
                        </tr>


					<?php endwhile; ?>
                    <!-- end of the loop -->

                    </table>

                    <!-- pagination here -->

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
                    <p><?php _e( 'Sorry! There are no coaching requests at this time.' ); ?></p>
				<?php endif; ?>
                <br><br>
                




                <?php /* Ninja Tables 
                <h2>Coaching Requests - Assigned Teams</h2>
                <?php 
                    //the_post();
                    echo do_shortcode( '[ninja_tables id="172"]'); 
                ?>

                <br><br>

                <h2>Coaching Requests - Un-Assigned Teams</h2>
                <?php 
                    //the_post();
                    echo do_shortcode( '[ninja_tables id="187"]'); 
                ?>
                */ ?>



			</div> <!-- #left-area -->
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
