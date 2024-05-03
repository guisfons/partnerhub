<?php
$user = wp_get_current_user();
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

$categories = get_categories(array(
    'taxonomy'   => $taxonomy,
    'orderby'    => 'name',
    'hide_empty' => true
));

if( isset( $_POST['submit_post'] ) ) {
    if( empty( $_POST['post_title'] ) || empty( $_POST['post_content'] ) ) {
        echo '<script>alert("Title and content are required.")</script>';
        exit;
    }

    if( ! isset( $_POST['form_processed'] ) ) {
        $post_title = sanitize_text_field( $_POST['post_title'] );
        $post_content = wp_kses_post( $_POST['post_content'] );
        $post_category = isset( $_POST['post_category'] ) ? $_POST['post_category'] : array();
        $post_tags = isset( $_POST['post_tags'] ) ? sanitize_text_field( $_POST['post_tags'] ) : '';

        $new_post = array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_type'     => 'bulletin_board',
            'tax_input'     => array(
                'bulletin_boards_categories' => array($post_category)
            )
        );

        $post_id = wp_insert_post( $new_post );

        if( $post_id ) {
        } else {
            echo '<script>alert("Error creating post.")</script>';
        }
    }
}
?>

<section class="wrapper card news__board">
    <h2>News Board</h2>

    <div>
        <?php
        if ($query->have_posts()) :

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
				'<div class="news__item" data-category="'.esc_attr($category_name).'">
					<figure>
						<span class="material-symbols-outlined">account_circle</span>
					</figure>
					<article data-user="'.(!empty(wp_get_current_user()->user_firstname) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name).'"><strong>'.get_the_title().'</strong> '.get_the_content().'</article>
				</div>';
			endwhile;
			wp_reset_postdata();
			echo '</div>';
		else : echo 'No news'; endif;
        ?>
    </div>

    <form method="post" class="news__bulletin">
        <label for="post_title">Title: <input type="text" name="post_title" required/></label>
        <label for="post_content">Content: <textarea name="post_content" required></textarea></label>
        <label for="post_category">Category:
        <?php
            wp_dropdown_categories( array(
                'taxonomy'         => 'bulletin_boards_categories',
                'hide_empty'       => 0,
                'name'             => 'post_category',
                'orderby'          => 'name',
                'hierarchical'     => 1,
                'show_option_none' => 'Select category'
            ));
        ?>
        </label>

        <input type="submit" name="submit_post" value="Create Post" />

        <span class="material-symbols-outlined news__bulletin-close">close</span>
    </form>
    <button>Create Post</button>
</section>