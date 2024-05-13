<?php

/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package itmidia
 * @since 1.0.0
 */

if (in_array(session_status(), [PHP_SESSION_NONE, 1])) {
	session_start();
}

/**
 * Composer autoload
 */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once (__DIR__ . '/vendor/autoload.php');
}

/**
 * @todo improve to use namespaces and Helpers be a class
 */
require_once (__DIR__ . '/src/Helpers.php');
require_once(__DIR__ . '/inc/post-types.php');
#require_once(__DIR__ . '/inc/shortcodes/galleries.php');
#require_once(__DIR__ . '/inc/shortcodes/special-posts-videos.php');

/**
 * @info Security Tip
 * Remove version info from head and feeds
 */
add_filter('the_generator', 'wp_version_removal');

function wp_version_removal() {
    return false;
}

/**
 * @info Security Tip
 * Disable oEmbed Discovery Links and wp-embed.min.js
 */
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

/**
 * @bugfix Yoast fix wrong canonical url in production
 *
 * Set canonical URLs on non-production sites to the production URL
 */
#add_filter( 'wpseo_canonical', function( $canonical ) {
#	$canonical = preg_replace('#//[^/]*/#U', '//itmorum365.com.br/', trailingslashit( $canonical ) );
#	return $canonical;
#});

/**
 * Filter except length to 35 words.
 *
 * @param integer $length
 * @return integer
 */
function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Add excerpt support for pages
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Remove Admin Bar from front-end
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Disables block editor "Gutenberg"
 */
add_filter("use_block_editor_for_post_type", "use_gutenberg_editor");
function use_gutenberg_editor() {
    return false;
}

/**
 * Add support to thumbnails
 */
add_theme_support('post-thumbnails');

/**
 * @info this theme doesn't have custom thumbnails dimensions
 *
 * define the size of thumbnails
 * To enable featured images, the current theme must include
 * add_theme_support( 'post-thumbnails' ) and they will show the metabox 'featured image'
 */
add_image_size('company-size', 162, 81, false );
add_image_size('event-gallery', 490, 568, false );
/*add_image_size('slide-large', 1366, 400, true );
add_image_size('slide-extra-large', 2560, 749, true );*/


/**
 * Páginas Especiais
 */

if( function_exists('acf_add_options_page') ) {

   /* @info disabled by unused*/
    acf_add_options_page(array(
        'page_title' => 'General Options',
        'menu_title' => 'General Options',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-settings',
        'position'   => 2

    ));

    // acf_add_options_page(array(
    //     'page_title' => 'Destaques',
    //     'menu_title' => 'Destaques',
    //     'menu_slug'  => 'uau-slides',
    //     'capability' => 'edit_posts',
    //     'redirect'   => false,
    //     'icon_url'   => 'dashicons-excerpt-view',
    //     'position'   => 3
	// ));

}


/**
 * Registering Locations of Navigation Menus
 */

function navigation_menus(){
    /* this function register a array of locations */
    register_nav_menus(
        array(
			'header-menu' => 'Menu Header',
        )
    );
}

add_action('init', 'navigation_menus');

/**
 * ACF Improvements
 * Order results by descendent date in relational fields
 *
 * @param array $args
 * @param array $field
 * @param integer $post_id
 * @return array
 */
function relational_fields_order( $args, $field, $post_id ) {
    $args['orderby'] = 'date';
	$args['order'] = 'DESC';
	return $args;
}
add_filter('acf/fields/relationship/query', 'relational_fields_order', 10, 3);

/**
 * ACF Improvements
 * Order results by descendent date in post object fields
 *
 * @param array $args
 * @param array $field
 * @param integer $post_id
 * @return array
 */
function post_objects_fields_order( $args, $field, $post_id ) {
    $args['orderby'] = 'date';
	$args['order'] = 'DESC';
	return $args;
}
add_filter('acf/fields/post_object/query', 'post_objects_fields_order', 10, 3);

/**
 * Declaring the JS files for the site
 */

function scripts() {
    wp_deregister_script("jquery");
}
add_action('wp_enqueue_scripts','scripts', 10);


/**
 * Applying custom logo at WP login form
 */
function login_logo() {
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg");
            width:260px;
            height:55px;
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>
<?php
}
add_action( 'login_enqueue_scripts', 'login_logo' );

function login_logo_url() {
    return home_url();
}

add_filter( 'login_headerurl', 'login_logo_url' );

function login_logo_url_title() {
    return 'IT Mídia';
}

add_filter( 'login_headertext', 'login_logo_url_title' );


/**
 * Declaring the JS files for the site
 */
// add_action('wp_enqueue_scripts','scripts', 10); // priority 10

REQUIRE_ONCE('inc/style-scripts.php');


/**
 * Pagination of posts in pages
 */
function pagination($pages = '', $range = 4) {
   $showitems = ($range * 2) + 1;

   global $paged;
   if (empty($paged)) $paged = 1;

   if ($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages;
      if (!$pages) {
         $pages = 1;
      }
   }

   if (1 != $pages) {
      echo "<div class=\"pagination__arrow\">";
      if ($paged > 1 && $showitems < $pages) echo "<a href='" . get_pagenum_link($paged - 1) . "'><svg width=\"10\" height=\"17\"><use xlink:href=\"" . get_template_directory_uri() . "/assets/img/SVG/sprite.svg#p-arrow-left\"></use></svg>Anterior</a>";
      echo "</div>";

      echo '<div class="pagination__numbers">';
      for ($i = 1; $i <= $pages; $i++) {
         if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
            echo ($paged == $i) ? "<a href=\"\" class=\"active\">" . $i . "</a>" : "<a href='" . get_pagenum_link($i) . "'>" . $i . "</a>";
         } elseif ($i == $paged) {
            echo '<a href=\"\" class=\"active\">' . $i . '</a>';
         }
      }
      echo '</div>';

      echo "<div class=\"pagination__arrow pagination__arrow--right\">";         
      if ($paged < $pages && $showitems < $pages) echo "<a href='" . get_pagenum_link($paged + 1) . "'>Próxima<svg width=\"10\" height=\"17\"><use xlink:href=\"" . get_template_directory_uri() .  "/assets/img/SVG/sprite.svg#p-arrow-right\"></use></svg></a>";
      echo "</div>";
   }
}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
        return $data;
    }

    $filetype = wp_check_filetype( $filename, $mimes );
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4 );
  
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
  
function fix_svg() {
    echo '<style type="text/css">
            .attachment-266x266, .thumbnail img {
                width: 100% !important;
                height: auto !important;
            }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

add_action('wp_ajax_upload_and_update_field', 'handle_file_upload_and_update_field');
add_action('wp_ajax_nopriv_upload_and_update_field', 'handle_file_upload_and_update_field');

function handle_file_upload_and_update_field() {
    // Check if the request is a valid POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = $_POST['postId'];
        $fieldKey = $_POST['fieldKey'];
        $rowIndex = isset($_POST['rowId']) ? intval($_POST['rowId']) : 0;
        $section_name = $_POST['sectionname'];
        $current_year = date('Y');
        $current_month = date('m');
        $post = get_post($postId);
        $post_name = $post->post_name;

        $upload_dir = wp_upload_dir();

        $post_folder_path = $upload_dir['basedir'] . '/' . $post_name;
        // $post_folder_path .= '/' . $current_year . '/' . $current_month;

        if (!file_exists($post_folder_path)) {
            mkdir($post_folder_path, 0755, true);
        }

        $year_month_folder_path = $post_folder_path . '/' . $current_year . '/' . $current_month;
        // Check if the folder exists, create it if not
        if (!file_exists($year_month_folder_path)) {
            mkdir($year_month_folder_path, 0755, true);
        }

        // Check if the file was uploaded successfully
        if($rowIndex == 0) {
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $uploaded_file = $_FILES['file'];

                $file_name = sanitize_file_name( $uploaded_file['name'] );
                $file_tmp_name = $_FILES["file"]["tmp_name"];
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

                // Upload the file and get the attachment ID
                $attachment_id = media_handle_upload('file', 0);

                if (is_wp_error($attachment_id)) {
                    // Error uploading the file
                    wp_send_json_error($attachment_id->get_error_message());
                } else {
                    // File uploaded successfully, you can access the file URL
                    $file_url = wp_get_attachment_url($attachment_id);
                    $file_path = get_attached_file($attachment_id);

                    // Move the file to the post folder
                    $destination = $year_month_folder_path . '/' . basename($file_path);

                    rename($file_path, $destination);
                    
                    update_field($fieldKey, $attachment_id, $postId);
                    
                    $image_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");
                    if (!in_array(strtolower($file_extension), $image_extensions)) {
                        $new_post = array(
                            'post_title'    => $file_name,
                            'post_content'  => $post_name . '<br/>' . $section_name,
                            'post_status'   => 'publish',
                            'post_author'   => get_current_user_id(),
                            'post_type'     => 'notifications',
                        );

                        wp_insert_post($new_post);
                    }

                    wp_send_json_success(array('message' => 'File uploaded successfully!', 'file_url' => $file_url, 'file_name' => $file_name));
                }
            } else {
                // File upload failed
                wp_send_json_error('File upload failed.');
            }
        } else {
            // Check if the post ID, field key, and row index are valid
            if ($postId > 0 && !empty($fieldKey) && $rowIndex > 0) {
                $uploaded_file = $_FILES['file'];
                // Get the existing repeater field values
                $repeaterFieldValues = get_field($fieldKey, $postId);

                // Check if the specified row index exists
                $totalRows = count($repeaterFieldValues);
                if ($rowIndex <= $totalRows) {
                    // Update the file field
                    $fileFieldKey = isset($_POST['fileFieldKey']) ? sanitize_text_field($_POST['fileFieldKey']) : '';
                    $fileAttachmentId = media_handle_upload('file', $postId); // 'file_field' should be the name attribute of your file input

                    if (!is_wp_error($fileAttachmentId)) {
                        // Update the file field value for the specified row
                        $repeaterFieldValues[$rowIndex - 1][$fileFieldKey] = $fileAttachmentId;

                        // File uploaded successfully, you can access the file URL
                        $file_url = wp_get_attachment_url($fileAttachmentId);
                        $file_path = get_attached_file($fileAttachmentId);
                        $filename = pathinfo($file_url, PATHINFO_BASENAME);
                        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

                        // Move the file to the post folder
                        $destination = $year_month_folder_path . '/' . basename($file_path);

                        rename($file_path, $destination);

                        // Update the ACF repeater field
                        update_field($fieldKey, $repeaterFieldValues, $postId);

                        $image_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");
                        if (!in_array(strtolower($file_extension), $image_extensions)) {
                            $new_post = array(
                                'post_title'    => $filename,
                                'post_content'  => $post_name . '<br/>' . $section_name,
                                'post_status'   => 'publish',
                                'post_author'   => get_current_user_id(),
                                'post_type'     => 'notifications',
                            );

                            wp_insert_post($new_post);
                        }

                        // Send a success response
                        wp_send_json_success(array('message' => 'File uploaded successfully!', 'file_url' => $file_url, 'file_name' => $filename));

                    } else {
                        // Error uploading the file
                        wp_send_json_error($fileAttachmentId->get_error_message());
                    }
                } else {
                    // Invalid row index
                    wp_send_json_error('Invalid row index: ' . $rowIndex . ', Total Rows: ' . $totalRows);
                }
            } else {
                // Invalid post ID, field key, or row index
                wp_send_json_error('Invalid post ID, field key, or row index. postId: ' . $postId . ', fieldKey: ' . $fieldKey . ', rowIndex: ' . $rowIndex);
            }
        }
    }

    wp_send_json_error('Invalid request.');
}

add_action('wp_ajax_multiple_update_repeater_items', 'handle_multiple_update_repeater_items');
add_action('wp_ajax_nopriv_multiple_update_repeater_items', 'handle_multiple_update_repeater_items');

function handle_multiple_update_repeater_items() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = $_POST['postId'];
        $fieldKey = $_POST['fieldKey'];
        $titleFieldKey = isset($_POST['titleFieldKey']) ? sanitize_text_field($_POST['titleFieldKey']) : '';
        $colorFieldKey = isset($_POST['colorFieldKey']) ? sanitize_text_field($_POST['colorFieldKey']) : '';
        $fontFieldKey = isset($_POST['fontFieldKey']) ? sanitize_text_field($_POST['fontFieldKey']) : '';
        
        $rowIndex = isset($_POST['rowId']) ? intval($_POST['rowId']) : 0;
        $color = isset($_POST['color']) ? sanitize_hex_color($_POST['color']) : '';
        $title = isset($_POST['title']) ? sanitize_textarea_field($_POST['title']) : '';
        $font = isset($_POST['font']) ? sanitize_textarea_field($_POST['font']) : '';
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';

        // Check if the file was uploaded successfully
        if ($postId > 0 && !empty($fieldKey) && $rowIndex > 0) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Update the specified fields in the repeater row
            if ($rowIndex <= count($repeaterFieldValues)) {
                if($type == 'color') {
                    if ($title !== '') {
                        $repeaterFieldValues[$rowIndex - 1][$titleFieldKey] = $title;
                    } else {
                        wp_send_json_error('Title empty.');
                    }

                    if ($color !== '') {
                        $repeaterFieldValues[$rowIndex - 1][$colorFieldKey] = $color;
                    } else {
                        wp_send_json_error('Color empty.');
                    }
                } else if($type == 'font') {
                    if ($title !== '') {
                        $repeaterFieldValues[$rowIndex - 1][$titleFieldKey] = $title;
                    } else {
                        wp_send_json_error('Title empty.');
                    }

                    if ($font !== '') {
                        $repeaterFieldValues[$rowIndex - 1][$fontFieldKey] = $font;
                    } else {
                        wp_send_json_error('Font value empty.');
                    }
                }

                update_field($fieldKey, $repeaterFieldValues, $postId);

                // Send a success response
                wp_send_json_success('Fields updated in repeater row successfully!');
            } else {
                // Invalid row index
                wp_send_json_error('Invalid row index. (PHP)');
            }
        } else {
            // Invalid post ID, field key, or row index
            wp_send_json_error('Invalid post ID, field key, or row index. (PHP)');
        }
    }

    wp_send_json_error('Invalid request.');
}

add_action('wp_ajax_remove_file_from_field', 'handle_remove_file_from_field');
add_action('wp_ajax_nopriv_remove_file_from_field', 'handle_remove_file_from_field');

function handle_remove_file_from_field() {
    // Check if the request is a valid POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';

        // Check if the post ID and field key are valid
        if ($postId > 0 && !empty($fieldKey)) {
            // Update the ACF file field with null or an empty string
            update_field($fieldKey, null, $postId);

            // Send a success response
            wp_send_json_success('File removed successfully!');
        } else {
            // Invalid post ID or field key
            wp_send_json_error('Invalid post ID or field key.');
        }
    }

    wp_send_json_error('Invalid request.');
}

add_action('wp_ajax_add_repeater_row', 'handle_add_repeater_row');
add_action('wp_ajax_nopriv_add_repeater_row', 'handle_add_repeater_row');

function handle_add_repeater_row() {
    // Check if the request is a valid POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';

        // Check if the post ID and field key are valid
        if ($postId > 0 && !empty($fieldKey)) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Add a new row to the repeater field
            $newRow = array('column1' => 'New Value 1', 'column2' => 'New Value 2');
            $repeaterFieldValues[] = $newRow;

            // Update the ACF repeater field
            update_field($fieldKey, $repeaterFieldValues, $postId);

            wp_send_json_success(array('message' => 'Row added to repeater field successfully'));
        } else {
            // Invalid post ID or field key
            wp_send_json_error('Invalid post ID or field key.');
        }
    }

    wp_send_json_error('Invalid request.');
}

add_action('wp_ajax_update_repeater_row', 'handle_update_repeater_row');
add_action('wp_ajax_nopriv_update_repeater_row', 'handle_update_repeater_row');

function handle_update_repeater_row() {
    // Check if the request is a valid POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';
        $rowIndex = isset($_POST['rowId']) ? intval($_POST['rowId']) : -1;

        // Check if the post ID, field key, and row index are valid
        if ($postId > 0 && !empty($fieldKey) && $rowIndex >= 0) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Update the values for the specified row
            $repeaterFieldValues[$rowIndex] = array(/* your updated field values for the row */);

            // Update the ACF repeater field
            update_field($fieldKey, null, $postId);

            // Send a success response
            wp_send_json_success('Row in repeater field updated successfully!');
        } else {
            // Invalid post ID, field key, or row index
            wp_send_json_error('Invalid post ID, field key, or row index.');
        }
    }

    wp_send_json_error('Invalid request.');
}

add_action('wp_ajax_delete_repeater_row', 'handle_delete_repeater_row');
add_action('wp_ajax_nopriv_delete_repeater_row', 'handle_delete_repeater_row');

function handle_delete_repeater_row() {
    // Check if the request is a valid POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';
        $rowId = isset($_POST['rowId']) ? intval($_POST['rowId']) : 0;
        $filename = isset($_POST['fileName']) ? sanitize_text_field($_POST['fileName']) : '';

        // Check if the post ID, field key, and row index are valid
        if ($postId > 0 && !empty($fieldKey) && $rowId > 0) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Remove the specified row from the repeater field
            if ($rowId <= count($repeaterFieldValues)) {
                $query = new WP_Query(array(
                    'post_type' => 'notifications',
                    'post_status' => 'publish',
                    'posts_per_page' => 1,
                    'title' => $filename
                ));
    
                if ($query->have_posts()) {
                    $post = $query->posts[0];
                    $post_id = $post->ID;
                } else {
                    $post_id = '';
                }

                wp_delete_post($post_id, true);

                delete_row($fieldKey, $rowId, $postId);
                wp_send_json_success('Row removed from repeater field successfully!');
            } else {
                // Invalid row index
                wp_send_json_error('Invalid row index.');
            }
        } else {
            // Invalid post ID, field key, or row index
            wp_send_json_error('Invalid post ID, field key, or row index.');
        }
    }

    wp_send_json_error('Invalid request.');
}

add_action('wp_ajax_add_images_to_gallery', 'handle_add_images_to_gallery');
add_action('wp_ajax_nopriv_add_images_to_gallery', 'handle_add_images_to_gallery');

function handle_add_images_to_gallery() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $galleryFieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';

        $files = $_FILES[$_POST['nameField']];

        if ($postId > 0) {
            if (!empty($files['name'][0])) {
                $attach_ids = array();  // Array to store attachment IDs

                // Get the current gallery images
                $current_gallery = get_field($galleryFieldKey, $postId);

                // If there are existing images, add them to the $attach_ids array
                if ($current_gallery && is_array($current_gallery)) {
                    $attach_ids = $current_gallery;
                }

                foreach ($files['name'] as $key => $value) {
                    if ($files['name'][$key]) {
                        $file = array(
                            'name'     => $files['name'][$key],
                            'type'     => $files['type'][$key],
                            'tmp_name' => $files['tmp_name'][$key],
                            'error'    => $files['error'][$key],
                            'size'     => $files['size'][$key]
                        );

                        // Set the file array in $_FILES
                        $_FILES = array($_POST['nameField'] => $file);

                        // Upload each file using media_handle_upload and get the attachment ID
                        $attach_id = media_handle_upload($_POST['nameField'], $postId);

                        // Store the attachment ID in the array
                        if (is_numeric($attach_id)) {
                            $attach_ids[] = $attach_id;
                        }
                    }
                }

                // Update the ACF gallery field with the combined array
                update_field($galleryFieldKey, $attach_ids, $postId);

                $imageUrls = array_map('wp_get_attachment_url', $attach_ids);

                // Send a success response
                wp_send_json_success(array('imageUrls' => $imageUrls), 'Images added to the gallery successfully!');
            } else {
                // No files uploaded
                wp_send_json_error('No images uploaded.');
            }
        } else {
            // Invalid post ID
            wp_send_json_error('Invalid post ID.');
        }
    } else {
        // Invalid request method
        wp_send_json_error('Invalid request method.');
    }
}

add_action('wp_ajax_empty_gallery_field', 'handle_empty_gallery_field');
add_action('wp_ajax_nopriv_empty_gallery_field', 'handle_empty_gallery_field');

function handle_empty_gallery_field() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';

        // Check if the post ID and field key are valid
        if ($postId > 0 && !empty($fieldKey)) {
            // Get the ACF gallery field key
            $galleryFieldKey = acf_get_field($fieldKey)['key'];

            // Update the ACF gallery field with an empty array
            update_field($galleryFieldKey, array(), $postId);

            // Send a success response
            wp_send_json_success('Gallery field emptied successfully!');
        } else {
            // Invalid post ID or field key
            wp_send_json_error('Invalid post ID or field key.');
        }
    } else {
        // Invalid request method
        wp_send_json_error('Invalid request method.');
    }
}

if ( ! function_exists( 'wp_handle_upload' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

function my_handle_attachment($file_handler,$post_id,$set_thu=false) {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
  
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
  
    $attach_id = media_handle_upload( $file_handler, $post_id );
    if ( is_numeric( $attach_id ) ) {
      update_post_meta( $post_id, '_my_file_upload', $attach_id );
    }
    return $attach_id;
  }

add_action('admin_init', 'restrict_dashboard_access');
function restrict_dashboard_access() {
    if (!current_user_can('manage_options') && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php') {
        $user = wp_get_current_user();    

        if(in_array( 'contributor', (array) $user->roles )) {
            $posts = get_posts(array(
                'posts_per_page'    => -1,
                'post_type'     => 'hotels',
                'meta_key'      => 'user',
                'meta_value'    => in_array(get_current_user_id(), get_user_id),
            ));    
        } else {
            wp_redirect(home_url());
        }

        exit;
    }
}

add_action('wp_ajax_ajax_search', 'ajax_search_callback');
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search_callback');
function ajax_search_callback() {
    $search_query = sanitize_text_field($_POST['search']);
    $args = array(
        'post_type' => 'notifications',
        's' => $search_query,
        'posts_per_page' => -1,
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
        echo 'No results found';
    }
    wp_reset_postdata();
    die();
}

function get_file_icon($url) {
    $icon = '';
    if (!empty($url)) {
        $info = new SplFileInfo($url);
        switch ($info->getExtension()) {
            case 'pdf':
                $color = '#fc5f4c';
                break;
            case 'xls':
            case 'xlsx':
                $color = '#107c41';
                break;
            default:
                $color = '#434343';
        }
        $icon = '<figure><svg id="eB0JEjPqx6d1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 49" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path d="M4.615079,2.653579L27.5022,2.570655l8.872906,10.531393v32.920968h-31.760027v-43.369437Z" fill="none" stroke="#434343" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M26.38157,2.570652v10.531393h9.993536L27.5022,2.570652h-1.12063Z" transform="translate(0 0.000003)" fill="#434343" stroke="#434343" stroke-width="0.5" stroke-linejoin="round"/><path d="M2.031101,24.296836L31.958601,24.5v14.422172h-29.9275v-14.625336Z" fill="'.$color.'" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></figure>';
    }
    return $icon;
}

function get_service_url($url, $post_id) {
    if (!empty($url)) {
        $path_parts = explode('/', $url);
        $uploads_index = array_search('uploads', $path_parts);
        $new_path_parts = array_merge(
            array_slice($path_parts, 0, $uploads_index + 1),
            array(get_post_field('post_name', $post_id)),
            array_slice($path_parts, $uploads_index + 1)
        );
        return implode('/', $new_path_parts);
    }
    return '';
}

function render_file_row($service, $x, $post_id, $field_key, $file_field_key) {
    $icon = get_file_icon($service['url']);
    $service_url = get_service_url($service['url'], $post_id);

    echo '<div data-row-index="'.$x.'" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="table__row">
        <span class="table__row-title">'.$icon.$service['filename'].'</span>
        <div class="table__row-controls">
            <button class="table__row-controls-view" data-url="'.$service_url.'">View</button>
            <button class="table__row-controls-delete">Remove</button>
            <button class="table__row-controls-share"><span class="material-symbols-outlined">share</span></button>
        </div>
    </div>';
}

function render_empty_file_row($x, $post_id, $field_key, $file_field_key) {
    echo
    '<div data-row-index="'.$x.'" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="table__row">
        <div class="table__row-form">
            <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="file-field" enctype="multipart/form-data">
                <input type="file" class="file" accept="application/pdf">
                <button type="button" class="table__row-upload upload-file upload-repeater-file">Upload file</button>
            </form>
        </div>
        <div class="table__row-controls">
            <button class="table__row-controls-delete">Remove</button>
        </div>
    </div>';
}

function show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, $model) {
    $output = '';
    $field_key = acf_get_field($field_name)['key'];
    if(!empty(acf_get_field($subfield_name)['key'])) {
        $file_field_key = acf_get_field($subfield_name)['key'];
    }

    $rows = get_field($field_name);
    ob_start();
    ?>
    <div class="card__header"><h3><?= $section_title; ?></h3></div>
    <div class="card__body">
        <?php
        if($model == '') {
            if ($rows):
                $last_row = end($rows);
                $last_row_field = $last_row[$subfield_name];
                $last_row_index = count($rows);

                if (!empty($last_row_field['url'])):
                    $icon = get_file_icon($last_row_field['url']);
                    ?>
                    <div class="table table--new">
                        <div class="table__header">New</div>
                        <div class="table__body">
                            <div data-row-index="<?= $last_row_index; ?>" data-post-id="<?= $post_id; ?>" data-field-key="<?= $field_key; ?>" data-file-field-key="<?= $file_field_key; ?>" class="table__row">
                                <span class="table__row-title"><?= $icon . $last_row_field['filename']; ?></span>

                                <div class="table__row-controls">
                                    <button class="table__row-controls-view" data-url="<?= get_service_url($last_row_field['url'], $post_id); ?>">View</button>
                                    <button class="table__row-controls-delete">Remove</button>
                                    <button class="table__row-controls-share"><span class="material-symbols-outlined">share</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
            endif;
            echo
            '<div class="table">
                <div class="table__header"></div>
                <div class="table__body">';
            if($model == '') {
                if (have_rows($field_name)):
                    $x = 1;
                    while (have_rows($field_name)): the_row();
                        $service = get_sub_field($subfield_name);
                        $icon = '';
                        $service_url = '';

                        if (!empty($service)) {
                            if (!empty($service['url'])) {
                                $icon = get_file_icon($service['url']);
                                $service_url = get_service_url($service['url'], $post_id);
                            }

                            if ($last_row_index !== $x) {
                                render_file_row($service, $x, $post_id, $field_key, $file_field_key);
                            }
                        } else {
                            render_empty_file_row($x, $post_id, $field_key, $file_field_key);
                        }
                        $x++;
                    endwhile;
                endif;
                echo
                    '</div>
                    <div class="table__foot"><span class="table__foot-addrow" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Add '.$repeater_title.'</span></div>
                </div>';
            }
        }

        if($model == 'single') {
            if(!empty(get_field($field_name))) {
                $filename = get_field($field_name)['filename'];
                $url = get_field($field_name)['url'];
                $key = acf_get_field($field_name)['key'];
                $icon = get_file_icon($url);
                
                echo
                '<div class="table">
                    <div class="table__header"></div>
                    <div class="table__body">
                        <div data-post-id="'. $post_id .'" data-field-key="'. $field_key .'" data-file-field-key="'. $file_field_key .'" class="table__row">
                            <span class="table__row-title">'. $icon . $filename.'</span>
                            <div class="table__row-controls">
                                <button class="table__row-controls-view" data-url="'. get_service_url($url, $post_id).'">View</button>
                                <button class="table__row-controls-delete">Remove</button>
                                <button class="table__row-controls-share"><span class="material-symbols-outlined">share</span></button>
                            </div>
                        </div>
                    </div>
                </div>';
            } else {
                echo
                '<div class="table">
                    <div class="table__header"></div>
                    <div class="table__body">
                        <div class="table__row">
                            <div class="table__row-form">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="file-field" enctype="multipart/form-data">
                                    <input type="file" class="file" accept="application/pdf">
                                    <button type="button" class="table__row-upload upload-file upload-repeater-file">Upload file</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }

        if($model == 'colour') {
            $field_key = acf_get_field($field_name)['key'];
            $title_field_key = acf_get_field($field_name)['sub_fields'][0]['key'];
            $color_field_key = acf_get_field($field_name)['sub_fields'][1]['key'];

            echo
            '<div class="table">
                <div class="table__header"></div>
                <div class="table__body">';

            if (have_rows($field_name)):
                list($subfield1, $subfield2) = explode(',', $subfield_name, 2);
                $subfield1 = get_sub_field($subfield1);
                $subfield2 = get_sub_field($subfield2);

                $x = 1;
                while (have_rows($field_name)): the_row();
                    $title = get_sub_field('title');
                    $colour = get_sub_field('colour');

                    if(!empty($title)) {
                        echo
                        '<div data-row-index="'.$x.'" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-color-key="'.$color_field_key.'" class="table__row">
                            <span class="table__row-title">
                                <span>
                                    <input type="text" class="title-field" placeholder="'.$title.'" value="'.$title.'" disabled>
                                    <span class="table__row-colour color-field" style="background-color: '.$colour.'"></span>
                                </span>
                            </span>
                            <div class="table__row-controls">
                                <button class="table__row-controls-delete">Remove</button>
                            </div>
                        </div>';
                    } else {
                        echo
                        '<div data-row-index="'.$x.'" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-color-key="'.$color_field_key.'" class="table__row">
                            <div class="table__row-form">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-color-key="'.$color_field_key.'">
                                    <input type="text" class="title-field" placeholder="Colour Title" value="Colour Title" required>
                                    <input type="color" class="color-field" required>
                                    <button type="button" class="table__row-controls-upload">Submit</button>
                                </form>
                            </div>
                            <div class="table__row-controls">
                                <button class="table__row-controls-delete">Remove</button>
                            </div>
                        </div>';
                    }
                    $x++;
                endwhile;
            endif;
            echo
                '</div>
                <div class="table__foot"><span class="table__foot-addrow table__foot-addrow--color" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'. $title_field_key. '" data-color-key="'. $color_field_key. '">Add '.$repeater_title.'</span></div>
            </div>';
        }

        if($model == 'font') {
            $field_key = acf_get_field($field_name)['key'];
            $title_field_key = acf_get_field($field_name)['sub_fields'][0]['key'];
            $color_field_key = acf_get_field($field_name)['sub_fields'][1]['key'];

            echo
            '<div class="table">
                <div class="table__header"></div>
                <div class="table__body">';

            if (have_rows($field_name)):
                list($subfield1, $subfield2) = explode(',', $subfield_name, 2);
                $subfield1 = get_sub_field($subfield1);
                $subfield2 = get_sub_field($subfield2);

                $x = 1;
                while (have_rows($field_name)): the_row();
                    $title = get_sub_field('title');
                    $font = get_sub_field('font');

                    if(!empty($title)) {
                        echo
                        '<div data-row-index="'.$x.'" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-color-key="'.$color_field_key.'" class="table__row">
                            <span class="table__row-title">
                                <span>
                                    <strong>Font name:</strong> '.$title.' <strong>Font family: </strong>'.$font.'
                                </span>
                            </span>
                            <div class="table__row-controls">
                                <button class="table__row-controls-delete">Remove</button>
                            </div>
                        </div>';
                    } else {
                        echo
                        '<div data-row-index="'.$x.'" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-color-key="'.$color_field_key.'" class="table__row">
                            <div class="table__row-form">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-font-key="'.$color_field_key.'">
                                    <input type="text" class="title-field" placeholder="Font name" value="Font Title" required>
                                    <input type="text" class="font-field" placeholder="Font family" value="Font family" required>
                                    <button type="button" class="table__row-controls-upload">Submit</button>
                                </form>
                            </div>
                            <div class="table__row-controls">
                                <button class="table__row-controls-delete">Remove</button>
                            </div>
                        </div>';
                    }
                    $x++;
                endwhile;
            endif;
            echo
                '</div>
                <div class="table__foot"><span class="table__foot-addrow table__foot-addrow--font" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'. $title_field_key. '" data-color-key="'. $color_field_key. '">Add '.$repeater_title.'</span></div>
            </div>';
        }
        
    echo '</div></div>';

    $output = trim(ob_get_clean());
    return $output;
}

function show_gallery($post_id, $section_title, $field_name) {
    echo '<div class="card__header"><h3>'.$section_title.'</h3></div><div class="card__body"><div class="table table--gallery"><div class="table__header"></div><div class="table__body">';
    $images = get_field($field_name);
    $field_key = acf_get_field($field_name)['key'];
    $file_array = preg_replace("/[^a-zA-Z]+/", "", $section_title);

    if ($images) :
        foreach ($images as $image) :
            $image_title = $image['alt'];
            $image_url = $image['url'];
            $image_filename = $image['filename'];

            echo
            '<div class="table__row">
                <span class="table__row-title">
                    ' . $image_filename . '
                    <figure style="display: none;"><img style="display: none;" lazy="load" src="' . $image_url . '" alt="' . $image_title . '"></figure>
                </span>
                <div class="table__row-controls"><a href="' . $image_url . '" title="' . $image_title . '" target="_blank">View</a></div>
            </div>';
        endforeach;
        echo
        '</div><div class="table__foot">
            <span class="remove-images" data-field-key="' . $field_key . '">Remove images</span>
            <span class="download-images"><span class="material-symbols-outlined">download</span></span>
            <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="gallery-field" enctype="multipart/form-data">
                <input type="file" accept="image/*" name="'.$file_array.'[]" multiple required>
                <button type="button" class="upload-gallery">Submit</button>
            </form>
        </div>';
    else :
        echo
        '</div><div class="table__foot">
            <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="gallery-field" enctype="multipart/form-data">
                <input type="file" accept="image/*" name="'.$file_array.'[]" multiple required>
                <button type="button" class="upload-gallery">Submit</button>
            </form>
        </div>';
    endif;
    echo '</div></div></div>';
}