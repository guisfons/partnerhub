<?php
get_header();
loadModulesCssForTemplate('home.min.css');

if(is_user_logged_in()) {
	$user = wp_get_current_user();
	
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('headofoperations', (array) $user->roles) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {

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

	if(current_user_can('contributor')) {
		echo '<section class="home__hotel">';
		echo '<nav class="breadcrumb"><a href="'.get_home_url().'" title="Home">Home</a></nav>';
        while ( have_posts() ) : the_post();
			loadModulesCssForTemplate('administration.min.css');
			get_template_part('template-parts/administration');
	
			loadModulesCssForTemplate('general-property.min.css');
			get_template_part('template-parts/general-info');

			get_template_part('template-parts/property-info');
	
			get_template_part('template-parts/regiotels-deliverables');

			get_template_part('template-parts/pricing-sheet');
        endwhile;
		echo '</section>';
	}
} else {
	echo '<section class="login-form">';
	wp_login_form();
	echo '</section>';
}
get_footer();