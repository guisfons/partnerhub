<?php
loadModulesCssForTemplate('home.min.css');

if(is_user_logged_in()) {
	$user = wp_get_current_user();

	if(is_front_page() || is_singular('hotels')): ?>
		<span class="title"><span>Hello, <?php echo $user->user_firstname; ?></span><br /><br />
			<h1><?= (!current_user_can('contributor') ? 'ADMINISTRATIVE PARTNERHUB HOME' : 'Hotel Administrative Panel'); ?></h1>
		</span>
	<?php
	endif;

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
        if(!in_array('contributor', (array) $user->roles)) {
            // get_template_part('template-parts/front-page/schedule');
			// get_template_part('template-parts/front-page/tickets');
			get_template_part('template-parts/front-page/notifications');
			get_template_part('template-parts/front-page/latest-updates');
        } else { ?>

		<!-- <div class="card administration__contact">
			<div class="card__header">
				<h3>RegiÔtels Team Contact Details</h3>
			</div>
			<div class="card__body">
				<?php
				$revenue_contact_id = get_field('revenue_contact');
				$revenue_contact_name = isset(get_userdata($revenue_contact_id)->first_name) ? get_userdata($revenue_contact_id)->first_name : '';
				$revenue_contact_last_name = isset(get_userdata($revenue_contact_id)->last_name) ? get_userdata($revenue_contact_id)->last_name : '';
				$revenue_contact_email = isset(get_userdata($revenue_contact_id)->user_email) ? get_userdata($revenue_contact_id)->user_email : '';

				if (have_rows('contacts', 'options')) :
					while (have_rows('contacts', 'options')) : the_row();
						$area = get_sub_field('area');
						$responsible = get_sub_field('responsible');

						echo '<div class="administration__contact-area"><h4>' . $area . '</h4>';

						if (!empty($revenue_contact_id) && $area == 'Revenue Management') {
							echo '<p><span><strong>' . ucwords($revenue_contact_name . ' ' . $revenue_contact_last_name) . '</strong></span></p>';
							echo '<p><a href="mailto:' . $revenue_contact_email . '" target="_blank">' . $revenue_contact_email . '</a></p>';
						} else {
							echo '<p><span><strong>' . $responsible . '</strong></span></p>';
						}

						if (have_rows('emails')) :
							while (have_rows('emails')) : the_row();
								$email = get_sub_field('email');
								echo '<p><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></p>';
							endwhile;
						endif;

						if (have_rows('contact_number')) :
							while (have_rows('contact_number')) : the_row();
								$number = get_sub_field('number');
								echo '<p><a href="tel:+' . $number . '" target="_blank">+' . $number . '</a></p>';
							endwhile;
						endif;
						echo '</div>';
					endwhile;
				endif;
				?>
			</div>
		</div> -->

		<?php }

		if(in_array('contributor', (array)$user->roles)) {
			get_template_part('template-parts/front-page/statistics');
			get_template_part('template-parts/front-page/notifications');
		}

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
