<?php
get_header();
loadModulesCssForTemplate('home.min.css');

if(is_user_logged_in()) {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {
		
		get_template_part('template-parts/front-page/header');
		get_template_part('template-parts/front-page/schedule');
		get_template_part('template-parts/front-page/tickets');
		get_template_part('template-parts/front-page/notifications');

		// if(!in_array('contributor', (array) $user->roles)) {
		// 	get_template_part('template-parts/front-page/newbulletin');
		// }

		get_template_part('template-parts/front-page/latest-updates');

	} else {
		echo '<h2>You have no permission to see this page</h2>';
	}
} else {
	echo '<section class="login-form">';
	wp_login_form();
	echo '</section>';
}
get_footer();