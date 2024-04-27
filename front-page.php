<?php
get_header();
loadModulesCssForTemplate('home.min.css');

if(is_user_logged_in()) {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles) ) {
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
				echo '<ul class="news__category"><li data-category="all" class="news__category-item news__category-item--active">All</li>';
				foreach ( $categories as $category ) {
					echo '<li data-category="'.$category->name.'" class="news__category-item">'.$category->name.'</li>';
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