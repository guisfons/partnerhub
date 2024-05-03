<?php
get_header();
loadModulesCssForTemplate('home.min.css');

$apiKey = 'LCCHHMEQHTD73DL83U3WQ6QQVDJU0VC7';
$baseUrl = 'https://api.clickup.com/api/v2/';

// Example function to get list of tasks
$oauthToken = '64ULTPT57OCABBR5O32BNLR7752TW6WS';
$baseUrl = 'https://api.clickup.com/api/v2/';

// Example function to get list of tasks
// function getTasks($oauthToken, $baseUrl) {
//     $headers = [
//         'Authorization: Bearer ' . $oauthToken
//     ];
//     $ch = curl_init($baseUrl . 'task');
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     $response = curl_exec($ch);
//     curl_close($ch);

//     if ($response) {
//         $tasks = json_decode($response, true);
//         return $tasks;
//     } else {
//         echo 'Failed to retrieve tasks';
//         return null;
//     }
// }

// // Example usage
// $tasks = getTasks($oauthToken, $baseUrl);
// if ($tasks && isset($tasks['err'])) {
//     echo 'Error: ' . $tasks['err'];
// } elseif ($tasks) {
//     echo 'Tasks retrieved successfully!';
//     // Do something with the tasks
// }

$feed_url = 'https://www.regiotels.com/feed/'; // Assuming feed_url is sent via POST
// Use $feed_url to fetch feed information, parse it, and send back response

// // Create a new SimplePie object
// $feed = new SimplePie();
// $feed->set_feed_url($feed_url);
// $feed->init();
// $feed->handle_content_type();

// // Check if the feed is loaded successfully
// if ($feed->error()) {
//     echo 'Error fetching feed: ' . $feed->error();
// } else {
//     // Iterate through each item in the feed and display relevant information
//     foreach ($feed->get_items() as $item) {
//         echo '<h2>' . $item->get_title() . '</h2>'; // Display the title
//         echo '<p>' . $item->get_description() . '</p>'; // Display the description/content
//         echo '<p>Published on: ' . $item->get_date('j F Y | g:i a') . '</p>'; // Display the publish date
//         echo '<p>Link: <a href="' . $item->get_permalink() . '">' . $item->get_permalink() . '</a></p>'; // Display the link to the full article
//     }
// }

if(is_user_logged_in()) {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {
		
		echo '<section class="wrapper header-user"><h1 class="title">ADMINISTRATIVE DASHBOARD</h1><a href="'.do_shortcode('[better_messages_my_messages_url]').'"><figure><img src="'.get_template_directory_uri().'/assets/img/messages.webp" alt="Messages"><span>'.do_shortcode('[better_messages_unread_counter hide_when_no_messages="1" preserve_space="1"]').'</span>Messages</figure></a><figure><img src="'.get_template_directory_uri().'/assets/img/user.webp" alt="'.$user->user_login.'">'.$user->user_login.'</figure></section>';
?>
		<section class="card notifications">
			<h2>Notifications</h2>
			<input type="search" name="search" id="search" placeholder="Search">

			<div class="notifications__tasks">
				<?php
				$args = array(
					'post_type' => 'notifications',
					'posts_per_page' => 20,
					'orderby' => 'date',
					'order' => 'DESC'
				);
				
				$query = new WP_Query($args);
				
				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						$hotel = explode('<br/>', get_the_content())[0];
						$section = strtolower(str_replace(' ', '-', explode('<br/>', get_the_content())[1]));
						
						echo
						'<div class="notifications__item">
							<figure>
								<span class="material-symbols-outlined">account_circle</span>
							</figure>
							<article data-user="'.(!empty(wp_get_current_user()->user_firstname) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name).'"><a href="'. get_home_url(). '/hotels/' . $hotel . '/#' . $section .'" title="'.get_the_title().'">'.get_the_title().'</a></article>
						</div>';
					}
				} else {
				
					echo "No notifications.";
				}
				
				// Restore original post data
				wp_reset_postdata();
				?>
			</div>
		</section>

		<!-- <?php
		if(!in_array('contributor', (array) $user->roles)) {
			get_template_part('template-parts/newbulletin');
		}
		?> -->

		<section class="card tickets">
			<h2>Tickets</h2>
			<input type="search" name="searc" id="search" placeholder="Search">
			<ul class="tickets__control">
				<button class="tickets__control-item tickets__control-item--active">Open</button>
				<button class="tickets__control-item">In Progress</button>
				<button class="tickets__control-item">Closed</button>
			</ul>

			<div class="tickets__tasks">

			</div>
		</section>

		<section class="latest-updates">
			<h2>WHAT'S GOING ON AT REGIÔTELS </h2>

			<div class="card">
				<h4>Current Offer</h4>
				
			</div>
			<div class="card">
				<h4>Social Media News</h4>
				
			</div>
			<div class="card">
				<h4>Latest Blog Post</h4>
				
			</div>
			<div class="card">
				<h4>Upcoming Events</h4>
				
			</div>
		</section>
		
<?php
	} else {
		echo '<h2>You have no permission to see this page</h2>';
	}
} else {
	echo '<section class="login-form">';
	wp_login_form();
	echo '</section>';
}
get_footer();