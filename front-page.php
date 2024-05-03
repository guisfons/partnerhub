<?php
get_header();
loadModulesCssForTemplate('home.min.css');

if(is_user_logged_in()) {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {
		
		echo '<section class="wrapper header-user"><h1 class="title">ADMINISTRATIVE DASHBOARD</h1><a href="'.do_shortcode('[better_messages_my_messages_url]').'"><figure><img src="'.get_template_directory_uri().'/assets/img/messages.webp" alt="Messages"><span>'.do_shortcode('[better_messages_unread_counter hide_when_no_messages="1" preserve_space="1"]').'</span>Messages</figure></a><figure><img src="'.get_template_directory_uri().'/assets/img/user.webp" alt="'.$user->user_login.'">'.$user->user_login.'</figure></section>';

		get_template_part('template-parts/schedule');
		get_template_part('template-parts/tickets');
		get_template_part('template-parts/notifications');

		// if(!in_array('contributor', (array) $user->roles)) {
		// 	get_template_part('template-parts/newbulletin');
		// }

		get_template_part('template-parts/latest-updates');

	} else {
		echo '<h2>You have no permission to see this page</h2>';
	}
} else {
	echo '<section class="login-form">';
	wp_login_form();
	echo '</section>';
}
get_footer();