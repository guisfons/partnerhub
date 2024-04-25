<?php
get_header();
loadModulesCssForTemplate('home.min.css');
if(is_user_logged_in()) {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {
		$args = array(
			'post_type'      => 'hotels',
			'posts_per_page' => -1,
			'meta_key'       => 'country',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
		);
		
		$query = new WP_Query($args);

		if ($query->have_posts()) :
			echo '<section class="wrapper card hotels"><h2>Hotel Management</h2>';
			
			$hotels_by_country = array();
			
			while ($query->have_posts()) : $query->the_post();
			
				if (in_array('administrator', (array) $user->roles) || in_array(get_current_user_id(), get_field('user'))) {
					$country = get_field('country');
				
					$hotels_by_country[$country][] = '<a href="'.get_the_permalink().'" title="'.get_the_title().'"><figure>'.(!empty(get_field('corporate_identity_logos')[0]['url']) ? '<img src="'.get_field('corporate_identity_logos')[0]['url'].'" alt="'.get_the_title().'">' : '<span class="material-symbols-outlined">room_service</span>').'</figure>'.get_the_title().'</a>';
				} else {
					echo '<h2 class="error">No Hotels found</h2>';
				}
			endwhile;
			

			foreach ($hotels_by_country as $country => $hotels) {
				echo '<div class="card card--minimal"><div class="card__header"><span class="material-symbols-outlined">add</span><h4>'.$country.'</h4></div><div class="card__body" style="display: none;">';
				foreach ($hotels as $hotel) {
					echo $hotel;
				}
				echo '</div></div>';
			}
			
			wp_reset_postdata();
			echo '</section>';
		endif;

		echo '<section class="wrapper card news"><h2>News</h2>';

		if(in_array( 'contributor', (array) $user->roles )) {
			$post_type = 'bulletin_board_c';
			$taxonomy = 'bulletin_boards_c_categories';
		} else {
			$post_type = 'bulletin_board';
			$taxonomy = 'bulletin_boards_categories';
		}

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
		);
	
		$query = new WP_Query($args);

		$categories = get_categories( array(
			'taxonomy'   => $taxonomy,
			'orderby'    => 'name',
			'hide_empty' => true
		) );
		
		if ($query->have_posts()) :
			echo '<div class="news__items">';

			if ( ! empty( $categories ) ) {
				echo '<ul><li data-category="all" class="news__category news__category--active">All</li>';
				foreach ( $categories as $category ) {
					echo '<li data-category="'.$category->name.'" class="news__category">'.$category->name.'</li>';
				}
				echo '</ul>';
			}
			echo '<div class="news__container">';
			while ($query->have_posts()) : $query->the_post();
				$post_categories = wp_get_post_terms(get_the_ID(), $taxonomy);

				$category_name = '';
				if (!empty($post_categories)) {
					$category_name = $post_categories[0]->name;
				}
		 
				echo
				'<div class="news__item card" data-category="'.esc_attr($category_name).'">
					<figure>
						<span class="material-symbols-outlined">account_circle</span>
						<figcaption>'.(!empty(wp_get_current_user()->user_firstname) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name).'</figcaption>
					</figure>
					<article><strong>'.get_the_title().'</strong> '.get_the_content().'</article>
				</div>';
			endwhile;
			wp_reset_postdata();
			echo '</div></div>';
		else : echo 'No news'; endif;

		if(!in_array( 'contributor', (array) $user->roles )):
			get_template_part('template-parts/newbulletin');
		endif;

		echo '</section>';

		echo '<section class="wrapper card learning-subjects"><a href="https://www.regiotels.com/learning-resources/" target="_blank">Learning Articles</a><a href="https://www.youtube.com/@RegiOtels" target="_blank">Learning Videos</a></section>';
	} else {
		echo '<h2>You have no permission to see this page</h2>';
	}
} else {
	echo '<section class="login-form">';
	wp_login_form();
	echo '</section>';
}
get_footer();