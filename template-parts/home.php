<?php
loadModulesCssForTemplate('home.min.css');

if(is_user_logged_in()) {
	$user = wp_get_current_user();

    if(in_array('contributor', (array)$user->roles)) {
		$posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'hotels',
			'meta_query' => array(
				array(
					'key' => 'user', // Assuming 'user' is the meta key
					'value' => '"' . get_current_user_id() . '"',
					'compare' => 'LIKE',
				),
			),
		));

		if(!empty($posts)) {
			$url = get_permalink($posts[0]->ID);
            $full_current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if($full_current_url !== $url) {
                echo '<script>window.location.replace("'.$url.'")</script>';
            }
		}
	}
	
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('headofoperations', (array) $user->roles) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('editor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {
		get_template_part('template-parts/front-page/header');
        
        if(!in_array('contributor', (array) $user->roles)) {
            get_template_part('template-parts/front-page/schedule');
        }

		get_template_part('template-parts/front-page/tickets');
		get_template_part('template-parts/front-page/notifications');

		get_template_part('template-parts/front-page/latest-updates');

	} else {
		echo '<h2>You have no permission to see this page</h2>';
	}
} else {
	echo '<section class="login"><div class="login__form"><figure><img src="'.get_template_directory_uri().'/assets/img/regiotels-partnerhub.webp" alt="Regiotels Logo"></figure>';
	$args = array(
		'echo' => false,
	);
	$form = wp_login_form( $args ); 
	$form = str_replace('name="log"', 'name="log" placeholder="Username"', $form);
	$form = str_replace('name="pwd"', 'name="pwd" placeholder="Password"', $form);
	echo $form;
	do_action( 'lostpassword_form' );
	echo '</div></section>';
}
?>