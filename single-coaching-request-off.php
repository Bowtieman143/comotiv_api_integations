<?php
acf_form_head();
get_header();
the_post();

$post_id = get_the_ID();
$user_id = get_current_user_id();
$author_id = get_the_author_meta('ID');
$author_first_name = get_the_author_meta('first_name');
$author_last_name = get_the_author_meta('last_name');
$author_email = get_the_author_meta('user_email');

$user_meta = get_user_meta($user_id);
$user_data = get_userdata($user_id);
$user_roles=$user_data->roles;

$urgency = get_field('urgency');
$coaching_need = get_field('coaching_need');
$coaching_nickname = get_field('coaching_nickname');
$assigned_coach_id = get_field('assigned_coach');

$assigned_coaching_team = get_field('assigned_coaching_team');


// Get comments
$args = array(
	'post_id' => $post_id,
	'orderby' => array('comment_date'),
	'order' => 'DESC',
	'number' => 1
);
$comment = get_comments( $args );
$comment_id = $comment[0]->comment_ID;

if ($comment) {
	//print_r($comment);
}




?>

    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">

                    <h1>Coaching Request</h1>
                    <hr><br>

                    <h3>Customer Details:</h3>
                    <p><strong>Customer Name:</strong> <?php echo $author_first_name; ?> <?php echo $author_last_name; ?></p>
                    <p><strong>Customer Email:</strong> <?php echo $author_email; ?></p>


                    <p><strong>Coaching Request Title:</strong> <?php the_title(); ?></p>
                    <p><strong>Urgency:</strong> <?php echo $urgency; ?></p>
                    <p><strong>Coaching Need:</strong> <?php echo $coaching_need; ?></p>

                    <p><strong>Assigned Coaching Team:</strong> <?php echo $assigned_coaching_team; ?></p>
                    <br><hr><br>

                    <?php /*
                    <h3>User Data</h3>
                    <?php print_r($user_data); ?>
                    */ ?>
                    

                    <?php if (in_array("um_coach", $user_roles)) : // If coach is logged in ?>

                        <h3>Updated Coaching Request:</h3>
                        <?php acf_form(array(
                            'post_id'       => $post_id,
                            'post_title'    => false,
                            'post_content'  => false,
                            'fields' => array('assigned_coaching_team', 'current_status'),
                            'submit_value'  => __('Update Coaching Details')
                        )); ?>
                        <br><hr><br>

                    <?php endif; ?>

                    <h3>Coaching Thread:</h3>
                    <?php comments_template( '', true ); ?>

	                <?php /* Show starting VideoAsk */ ?>
	                <?php if (in_array("um_coach", $user_roles)) : // If coach is logged in ?>

                        <iframe src="https://www.videoask.com/fovo41kwy" allow="camera; microphone; autoplay; encrypted-media;"
                                width="100%" height="650px" frameborder="0">
                        </iframe>

	                <?php else : // If user is logged in  ?>

                        <?php /* 
                        <iframe src="https://www.videoask.com/f5qyx543v#contact_email=dennis@lightsoutinteractive.com&contact_name=Dennis%2520Dinsmore" allow="camera; microphone; autoplay; encrypted-media;"
                                width="100%" height="650px" frameborder="0">
                        </iframe>
                        */ ?>


                        
                        <iframe src="https://ask.comotiv.com/frwd3ld48#contact_email=dennis@lightsoutinteractive.com&contact_name=Dennis%2520Dinsmore" allow="camera; microphone; autoplay; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>                        

	                <?php endif; ?>



                </div> <!-- #left-area -->
				<?php //get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>

