<?php
// Enqueue Divi parent and Child CSS
function my_theme_enqueue_styles() {

	$parent_style = 'divi-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'cmt-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version') );
	//wp_enqueue_style( 'cmt-typekit', 'https://use.typekit.net/csa6uuh.css');

	//wp_enqueue_script( 'fa-script', 'https://kit.fontawesome.com/daa1e4446b.js');
	wp_enqueue_script( 'cmt-script', get_stylesheet_directory_uri() . '/scripts.js', array ( 'jquery' ), 0.1, true);

}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );



function register_my_menu() {
	register_nav_menu('top-social-menu',__( 'Top Social Menu' ));
}
//add_action( 'init', 'register_my_menu' );


/* Advanced Custom Fields - Options Page */
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Comotiv Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Coaching Teams',
		'menu_title'	=> 'Coaching Teams',
		'parent_slug'	=> 'theme-general-settings',
	));

}


// function that runs when shortcode is called
function cmt_videoAsk_intro() { 

	$user_id = get_current_user_id();
	$user_data = get_userdata($user_id);
	$user_email = urlencode($user_data->data->user_email);
	$user_display_name = urlencode($user_data->data->display_name); 

	//$user_first_name = $user_data->data->user_first_name;
	//$user_last_name = $user_data->data->user_last_name;
 
	// Things that you want to do. 
	$rauol_intake = '<iframe src="https://ask.comotiv.com/frwd3ld48#contact_email=dennis@lightsoutinteractive.com&contact_name=Dennis%2520Dinsmore" allow="camera; microphone; autoplay; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>'; 
	$new_intake = '<iframe src="https://ask.comotiv.com/f4ktf3q80#contact_email=dennis@lightsoutinteractive.com&contact_name=Dennis%2520Dinsmore" allow="camera; microphone; autoplay; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>'; 		
	$intake_id = '<iframe src="https://ask.comotiv.com/f4ktf3q80#contact_email='.$user_email.'&contact_name='.$user_display_name.'" allow="camera; microphone; autoplay; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>'; 				
		
	// Output needs to be return
	return $intake_id;
} 

// register shortcode
add_shortcode('Video_Intro', 'cmt_videoAsk_intro'); 




function cmt_request_list() { 

	$user_id = get_current_user_id();
 
	// Define query
	$args = array(
		'numberposts'	=> -1,
		'post_type'		=> 'coaching-request',
		//'author'		=> $user_id,
		//'meta_key'		=> 'assigned_coaching_team',
		//'meta_compare' => '!=',
		//'meta_value'	=> "unassigned"	
	);
	$the_query = new WP_Query( $args );

	// Start output
	$request_list = '<div class="coaching_request_list">';

	if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();

		$post_id = get_the_ID();
		$post_title = get_the_title();
		$post_link = get_the_permalink();
		$assigned_coaching_team = get_field('assigned_coaching_team');
		$assigned_coach = get_field('assigned_coach');
		$author_id = get_the_author_meta( 'ID' );
		$author_name = get_the_author_meta( 'display_name', $author_id );


		$request_list .= '<div class="request">';
		$request_list .= '<h3><a href="'.$post_link.'">'.$post_title.'</a></h3>';
		$request_list .= '<h4>'.$assigned_coaching_team.'</h4>';
		$request_list .= '</div>';

		endwhile;
	endif;
	
	$request_list .= '</div>';
		
	// Output needs to be return
	return $request_list;
} 

// register shortcode
add_shortcode('Coach_Request_List', 'cmt_request_list'); 



// Display coaching request thread
function cmt_request_details() { 

	$post_id = get_the_ID();
	$request_details = "";
	$videoask_thread = get_field('videoask_thread');
	$videoAsk_iframe = '<iframe src="'.get_field('videoask_thread').'" allow="camera; microphone; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>';



	if ($videoask_thread) {
		$request_details = $videoAsk_iframe;
	} else {
		$request_details = "Sorry, your coaching request is still pending.";
	}
		
	// Output needs to be return
	return $request_details;
} 
add_shortcode('Coach_Request_Details', 'cmt_request_details'); 



/* ACF Output Custom Fields 
function my_comment_template( $comment, $args, $depth ) {
	echo $comment->comment_content;
}
*/



// Filter comments to use iFrame for Videoask
function filter_text( $comment_text, $comment = null ) {

	$comotiv_comment = "";

	// Define Videoask comments for filtering
	//$videoAsk_url = 'https://www.videoask.com/';
	$videoAsk_url = 'https://ask.comotiv.com/';
	$videoAsk_iframe_start = '<iframe src="';
	$videoAsk_iframe_end = '#contact_email=dennis@lightsoutinteractive.com&contact_name=Dennis%2520Dinsmore" allow="camera; microphone; encrypted-media;" width="100%" height="650px" frameborder="0"></iframe>';

	if (strpos($comment_text, $videoAsk_url) !== false) {
		//echo 'This is a VideoAsk URL';
		$comotiv_comment .= $videoAsk_iframe_start;
		$comotiv_comment .= $comment->comment_content;
		$comotiv_comment .= $videoAsk_iframe_end;
	} else {
		$comotiv_comment = $comment_text;
	}

	// Return the comment
	return $comotiv_comment;

}
add_filter( 'comment_text', 'filter_text', 10, 2 );

function comotiv_videoask_api_integration() {
	
	// Contains all the endpoints for the videoask integration
	function videoask_api_integration_endpoints() {
		
		// Route (relative) - /wp-json/comotiv/create-reply-comment
		register_rest_route( 'comotiv', '/create-reply-comment', array(
			'methods' => 'POST',
			'callback' => 'post_create_comment_reply',
		));
		
		// Route (relative) - /wp-json/comotiv/create-new-coach-request
		register_rest_route( 'comotiv', '/create-new-coach-request', array(
			'methods' => 'POST',
			'callback' => 'post_create_new_coach_request',
		));
		
	}
	add_action( 'rest_api_init', 'videoask_api_integration_endpoints' );
	
	function post_create_comment_reply($request_data){
		$agent = $_SERVER['HTTP_USER_AGENT'];
		
		$data = json_decode($request_data->get_body());
		$client_name = $data->contact->name;
		$latest_reply_index = count($data->contact->messages) - 1; 
 		$client_video_share_link = $data->contact->messages[$latest_reply_index]->share_url;
		 
		$comment_data = array(
			'comment_post_ID'      => 675,
			'comment_author'       => $client_name,
			'comment_author_email' => 'steven@onloaddevelopment.com',
			'comment_author_url'   => 'http://www.someiste.com',
			'comment_content'      => $client_video_share_link,
			'comment_author_IP'    => '127.3.1.1',
			'comment_agent'        => $agent,
			'comment_date'         => date('Y-m-d H:i:s'),
			'comment_date_gmt'     => date('Y-m-d H:i:s'),
			'comment_approved'     => 1,
		);
		wp_insert_comment($comment_data);
			
		$file = get_stylesheet_directory() . '/new-comment-payload-test.txt';
		file_put_contents($file, "Payload Details: ". ' ' . print_r($data, true) . "\n\n", FILE_APPEND);
		
		$slack_message = 'Hey! ' . $client_name . ' has repied to their coaching request. Check it out here ' . $client_video_share_link;
		$endpoint = 'https://hooks.slack.com/services/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';
		send_slack_message($endpoint, $slack_message);
		
		return $request_data;

	}
	
	function post_create_new_coach_request($request_data){
		$data = json_decode($request_data->get_body());
		$client_name = $data->contact->name;
		$client_video_share_link = $data->contact->answers[0]->share_url;
		// All post data
		$new_coaching_request = array(
			'post_title'   => $client_name, 
			'post_type'    => 'coaching-request',
			'post_status'  => 'publish',
			'meta_input' => array(
				'field_5f3eaf281eccf' => 3,
			)
		);
		// Creates a new post and gets the ID for it
		$new_coaching_request_id = wp_insert_post( $new_coaching_request );
		// All comment content
		$comment_data = array(
			'comment_post_ID'      => $new_coaching_request_id,
			'comment_author'       => $client_name,
			'comment_author_email' => 'steven@onloaddevelopment.com',
			'comment_author_url'   => 'http://www.someiste.com',
			'comment_content'      => $client_video_share_link,
			'comment_author_IP'    => '127.3.1.1',
			'comment_agent'        => $agent,
			'comment_date'         => date('Y-m-d H:i:s'),
			'comment_date_gmt'     => date('Y-m-d H:i:s'),
			'comment_approved'     => 1,
		);
		wp_insert_comment($comment_data);
		
		$file = get_stylesheet_directory() . '/new-coach-request-payload-test.txt';
		file_put_contents($file, "Payload Details: ". $client_name. ' ' . print_r($data, true) . "\n\n", FILE_APPEND);
		
		$slack_message = 'Hey! ' . $client_name . ' has just made a new coaching request. Check it out here ' . $client_video_share_link;
		$endpoint = 'https://hooks.slack.com/services/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';
		send_slack_message($endpoint, $slack_message);
		
		return array('You have submited a new coaching request');
	}
	
	// CUSTOM FUNCITON - FOR SENDING SLACK MESSAGES
	function send_slack_message($slack_endpoint, $message) {
		$body = array(
			'text'  => $message,
		);
		
		$body = wp_json_encode( $body );
		
		$options = array(
			'body'        => $body,
			'headers'     => array(
				'Content-Type' => 'application/json',
			),
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
		);
		
		//end of slack notificatio
		wp_remote_post( $slack_endpoint, $options );
	
	}
	
}
add_action( 'init', 'comotiv_videoask_api_integration' );