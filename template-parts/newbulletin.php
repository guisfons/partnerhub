<?php
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
</form>