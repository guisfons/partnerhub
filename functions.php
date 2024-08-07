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
if (file_exists(__DIR__ . "/vendor/autoload.php")) {
    require_once __DIR__ . "/vendor/autoload.php";
}

/**
 * @todo improve to use namespaces and Helpers be a class
 */
require_once __DIR__ . "/src/Helpers.php";
require_once __DIR__ . "/inc/post-types.php";
#require_once(__DIR__ . '/inc/shortcodes/galleries.php');
#require_once(__DIR__ . '/inc/shortcodes/special-posts-videos.php');

/**
 * @info Security Tip
 * Remove version info from head and feeds
 */
add_filter("the_generator", "wp_version_removal");

function wp_version_removal()
{
    return false;
}

/**
 * @info Security Tip
 * Disable oEmbed Discovery Links and wp-embed.min.js
 */
remove_action("wp_head", "wp_oembed_add_discovery_links", 10);
remove_action("wp_head", "wp_oembed_add_host_js");
remove_action("rest_api_init", "wp_oembed_register_route");
remove_filter("oembed_dataparse", "wp_filter_oembed_result", 10);

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
function custom_excerpt_length($length)
{
    return 40;
}
add_filter("excerpt_length", "custom_excerpt_length", 999);

/**
 * Add excerpt support for pages
 */
add_post_type_support("page", "excerpt");

/**
 * Remove Admin Bar from front-end
 */
add_filter("show_admin_bar", "__return_false");

/**
 * Disables block editor "Gutenberg"
 */
add_filter("use_block_editor_for_post_type", "use_gutenberg_editor");
function use_gutenberg_editor()
{
    return false;
}

/**
 * Add support to thumbnails
 */
add_theme_support("post-thumbnails");

/**
 * @info this theme doesn't have custom thumbnails dimensions
 *
 * define the size of thumbnails
 * To enable featured images, the current theme must include
 * add_theme_support( 'post-thumbnails' ) and they will show the metabox 'featured image'
 */
add_image_size("company-size", 162, 81, false);
add_image_size("event-gallery", 490, 568, false);
/*add_image_size('slide-large', 1366, 400, true );
 add_image_size('slide-extra-large', 2560, 749, true );*/

/**
 * Páginas Especiais
 */

if (function_exists("acf_add_options_page")) {
    /* @info disabled by unused*/
    acf_add_options_page([
        "page_title" => "General Options",
        "menu_title" => "General Options",
        "menu_slug" => "theme-general-settings",
        "capability" => "edit_posts",
        "redirect" => false,
        "icon_url" => "dashicons-admin-settings",
        "position" => 2,
    ]);

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

function navigation_menus()
{
    /* this function register a array of locations */
    register_nav_menus([
        "header-menu" => "Menu Header",
    ]);
}

add_action("init", "navigation_menus");

/**
 * ACF Improvements
 * Order results by descendent date in relational fields
 *
 * @param array $args
 * @param array $field
 * @param integer $post_id
 * @return array
 */
function relational_fields_order($args, $field, $post_id)
{
    $args["orderby"] = "date";
    $args["order"] = "DESC";
    return $args;
}
add_filter("acf/fields/relationship/query", "relational_fields_order", 10, 3);

/**
 * ACF Improvements
 * Order results by descendent date in post object fields
 *
 * @param array $args
 * @param array $field
 * @param integer $post_id
 * @return array
 */
function post_objects_fields_order($args, $field, $post_id)
{
    $args["orderby"] = "date";
    $args["order"] = "DESC";
    return $args;
}
add_filter("acf/fields/post_object/query", "post_objects_fields_order", 10, 3);

/**
 * Declaring the JS files for the site
 */

function scripts()
{
    wp_deregister_script("jquery");
}
add_action("wp_enqueue_scripts", "scripts", 10);

/**
 * Applying custom logo at WP login form
 */
function login_logo()
{
    ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.webp");
            width: 260px;
            height: 55px;
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>
<?php
}
add_action("login_enqueue_scripts", "login_logo");

function login_logo_url()
{
    return home_url();
}

add_filter("login_headerurl", "login_logo_url");

function login_logo_url_title()
{
    return "PartnerHub";
}

add_filter("login_headertext", "login_logo_url_title");

add_action("template_redirect", "redirects");
function redirects()
{
    $user = wp_get_current_user();

    if (!is_user_logged_in() && !isset($_GET["logged"])) {
        $redirect_url = add_query_arg("logged", "false", get_home_url());
        wp_redirect($redirect_url);
        exit();
    } else {
        if (
            in_array("contributor", (array) $user->roles) &&
            (is_front_page() || is_home() || is_singular("hotels"))
        ) {
            after_login_page("", $user);
        }
    }
}

add_action("wp_login_failed", "redirect_login_failed");
function redirect_login_failed()
{
    wp_redirect(get_home_url() . "?failed=true");
    exit();
}

add_action("admin_init", "restrict_dashboard_access");
function restrict_dashboard_access()
{
    if (defined("DOING_AJAX") && DOING_AJAX) {
        return;
    }

    $user = wp_get_current_user();
    $allowed_roles = [
        "administrator",
        "editor",
        "headofoperations",
        "revenuemanager",
    ];

    if (!array_intersect($allowed_roles, (array) $user->roles)) {
        after_login_page("", $user);
    }
}

add_action("wp_logout", "remove_query_after_logout", 10, 2);
function remove_query_after_logout()
{
    $redirect_url = remove_query_arg("logged", get_home_url(""));
    wp_redirect($redirect_url);
    exit();
}

add_action("wp_login", "after_login_page", 10, 2);
function after_login_page($user_login, $user)
{
    if (in_array("contributor", (array) $user->roles)) {
        $posts = get_posts([
            "posts_per_page" => -1,
            "post_type" => "hotels",
            "meta_query" => [
                [
                    "key" => "user",
                    "value" => '"' . get_current_user_id() . '"',
                    "compare" => "LIKE",
                ],
            ],
        ]);

        if (!empty($posts)) {
            $full_current_url =
                (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on"
                    ? "https"
                    : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $post_urls = [];

            foreach ($posts as $post) {
                $post_urls[] = get_permalink($post->ID);
            }

            if (!in_array($full_current_url, $post_urls)) {
                if (count($posts) == 1) {
                    $url = get_permalink($posts[0]->ID);
                    echo wp_redirect($url);
                    exit();
                } else {
                    wp_redirect("/hotel-select/");
                    exit();
                }
            }
        }
    } else {
        wp_redirect(home_url(""));
        exit();
    }
}

/**
 * Declaring the JS files for the site
 */
// add_action('wp_enqueue_scripts','scripts', 10); // priority 10

require_once "inc/style-scripts.php";

function my_custom_hotels_columns($columns)
{
    // Unset the existing columns you want to reorder
    unset($columns["title"]);
    unset($columns["date"]);

    // Define the new order of columns
    return array_merge(
        [
            "cb" => $columns["cb"],
            "title" => __("Title", "your-text-domain"),
            "hotel_code" => __("Hotel Code", "your-text-domain"),
            "date" => __("Date", "your-text-domain"),
        ],
        $columns
    );
}
add_filter("manage_hotels_posts_columns", "my_custom_hotels_columns");

function my_custom_hotels_column_content($column_name, $post_id)
{
    if ($column_name == "hotel_code") {
        $hotel_code_value = get_field("hotel_code", $post_id);
        echo esc_html($hotel_code_value);
    }
}
add_action(
    "manage_hotels_posts_custom_column",
    "my_custom_hotels_column_content",
    10,
    2
);

function my_custom_hotels_column_sortable($columns)
{
    $columns["hotel_code"] = "hotel_code";
    return $columns;
}
add_filter(
    "manage_edit-hotels_sortable_columns",
    "my_custom_hotels_column_sortable"
);

function my_custom_hotels_orderby($query)
{
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get("orderby");

    if ($orderby == "hotel_code") {
        $query->set("meta_key", "hotel_code");
        $query->set("orderby", "meta_value");
    }
}
add_action("pre_get_posts", "my_custom_hotels_orderby");

/**
 * Pagination of posts in pages
 */
function pagination($pages = "", $range = 4)
{
    $showitems = $range * 2 + 1;

    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }

    if ($pages == "") {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo "<div class=\"pagination__arrow\">";
        if ($paged > 1 && $showitems < $pages) {
            echo "<a href='" .
                get_pagenum_link($paged - 1) .
                "'><svg width=\"10\" height=\"17\"><use xlink:href=\"" .
                get_template_directory_uri() .
                "/assets/img/SVG/sprite.svg#p-arrow-left\"></use></svg>Anterior</a>";
        }
        echo "</div>";

        echo '<div class="pagination__numbers">';
        for ($i = 1; $i <= $pages; $i++) {
            if (
                1 != $pages &&
                (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) ||
                    $pages <= $showitems)
            ) {
                echo $paged == $i
                    ? "<a href=\"\" class=\"active\">" . $i . "</a>"
                    : "<a href='" . get_pagenum_link($i) . "'>" . $i . "</a>";
            } elseif ($i == $paged) {
                echo '<a href=\"\" class=\"active\">' . $i . "</a>";
            }
        }
        echo "</div>";

        echo "<div class=\"pagination__arrow pagination__arrow--right\">";
        if ($paged < $pages && $showitems < $pages) {
            echo "<a href='" .
                get_pagenum_link($paged + 1) .
                "'>Próxima<svg width=\"10\" height=\"17\"><use xlink:href=\"" .
                get_template_directory_uri() .
                "/assets/img/SVG/sprite.svg#p-arrow-right\"></use></svg></a>";
        }
        echo "</div>";
    }
}

// Allow SVG
add_filter(
    "wp_check_filetype_and_ext",
    function ($data, $file, $filename, $mimes) {
        global $wp_version;
        if ($wp_version !== "4.7.1") {
            return $data;
        }

        $filetype = wp_check_filetype($filename, $mimes);
        return [
            "ext" => $filetype["ext"],
            "type" => $filetype["type"],
            "proper_filename" => $data["proper_filename"],
        ];
    },
    10,
    4
);

function cc_mime_types($mimes)
{
    $mimes["svg"] = "image/svg+xml";
    return $mimes;
}
add_filter("upload_mimes", "cc_mime_types");

function fix_svg()
{
    echo '<style type="text/css">
            .attachment-266x266, .thumbnail img {
                width: 100% !important;
                height: auto !important;
            }
        </style>';
}
add_action("admin_head", "fix_svg");

add_action("wp_ajax_upload_and_update_field", "handle_file_upload_and_update_field");
add_action("wp_ajax_nopriv_upload_and_update_field", "handle_file_upload_and_update_field");

function handle_file_upload_and_update_field()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $postId = $_POST["postId"];
        $fieldKey = $_POST["fieldKey"];
        $rowIndex = isset($_POST["rowId"]) ? intval($_POST["rowId"]) : 0;
        $section_name = $_POST["sectionname"];
        $current_year = date("Y");
        $current_month = date("m");
        $post = get_post($postId);
        $post_name = $post->post_name;

        $upload_dir = wp_upload_dir();

        $post_folder_path = $upload_dir["basedir"] . "/" . $post_name;

        if (!file_exists($post_folder_path)) {
            mkdir($post_folder_path, 0755, true);
        }

        $year_month_folder_path =
            $post_folder_path . "/" . $current_year . "/" . $current_month;
        if (!file_exists($year_month_folder_path)) {
            mkdir($year_month_folder_path, 0755, true);
        }

        if ($rowIndex == 0) {
            if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                $uploaded_file = $_FILES["file"];

                $file_name = sanitize_file_name($uploaded_file["name"]);
                $file_tmp_name = $_FILES["file"]["tmp_name"];
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

                $attachment_id = media_handle_upload("file", 0);

                if (is_wp_error($attachment_id)) {
                    wp_send_json_error($attachment_id->get_error_message());
                } else {
                    $file_url = wp_get_attachment_url($attachment_id);
                    $file_path = get_attached_file($attachment_id);

                    $destination = $year_month_folder_path . "/" . basename($file_path);

                    if (rename($file_path, $destination)) {
                        update_attached_file($attachment_id, $destination);

                        $metadata = wp_generate_attachment_metadata(
                            $attachment_id,
                            $destination
                        );
                        wp_update_attachment_metadata(
                            $attachment_id,
                            $metadata
                        );
                    } else {
                        wp_send_json_error("Failed to move file.");
                    }

                    update_field($fieldKey, $attachment_id, $postId);

                    $image_extensions = [
                        "jpg",
                        "jpeg",
                        "png",
                        "gif",
                        "bmp",
                        "svg",
                        "webp",
                    ];

                    if (!in_array(strtolower($file_extension), $image_extensions)) {
                        $new_post = [
                            "post_title" => $file_name,
                            "post_content" => $post_name . "/" . $section_name,
                            "post_status" => "publish",
                            "post_author" => get_current_user_id(),
                            "post_type" => "notifications",
                        ];

                        wp_insert_post($new_post);

                        
                    }

                    wp_send_json_success([
                        "message" => "File uploaded successfully!",
                        "file_url" => $file_url,
                        "file_name" => $file_name,
                    ]);
                }
            } else {
                wp_send_json_error("File upload failed.");
            }
        } else {
            if ($postId > 0 && !empty($fieldKey) && $rowIndex > 0) {
                $uploaded_file = $_FILES["file"];
                $repeaterFieldValues = get_field($fieldKey, $postId);

                $totalRows = count($repeaterFieldValues);
                if ($rowIndex <= $totalRows) {
                    $fileFieldKey = isset($_POST["file_field_Key"]) ? sanitize_text_field($_POST["file_field_Key"]) : "";
                    $fileAttachmentId = media_handle_upload("file", $postId);

                    if (!is_wp_error($fileAttachmentId)) {
                        $repeaterFieldValues[$rowIndex - 1][$fileFieldKey] = $fileAttachmentId;

                        $file_url = wp_get_attachment_url($fileAttachmentId);
                        $file_path = get_attached_file($fileAttachmentId);
                        $filename = pathinfo($file_url, PATHINFO_BASENAME);
                        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

                        $destination = $year_month_folder_path . "/" . basename($file_path);

                        if (rename($file_path, $destination)) {
                            update_attached_file($fileAttachmentId, $destination);
    
                            $metadata = wp_generate_attachment_metadata($fileAttachmentId, $destination);

                            wp_update_attachment_metadata($fileAttachmentId, $metadata);
                        } else {
                            wp_send_json_error("Failed to move file.");
                        }

                        update_field($fieldKey, $repeaterFieldValues, $postId);

                        $image_extensions = [
                            "jpg",
                            "jpeg",
                            "png",
                            "gif",
                            "bmp",
                            "svg",
                            "webp",
                        ];

                        if (!in_array(strtolower($file_extension), $image_extensions)) {
                            $new_post = [
                                "post_title" => $filename,
                                "post_content" =>
                                    $post_name . "/" . $section_name,
                                "post_status" => "publish",
                                "post_author" => get_current_user_id(),
                                "post_type" => "notifications",
                            ];

                            wp_insert_post($new_post);
                        }

                        wp_send_json_success([
                            "message" => "File uploaded successfully!",
                            "file_url" => $file_url,
                            "file_name" => $filename,
                        ]);
                    } else {
                        wp_send_json_error($fileAttachmentId->get_error_message());
                    }
                } else {
                    wp_send_json_error("Invalid row index: " . $rowIndex .", Total Rows: " . $totalRows);
                }
            } else {
                wp_send_json_error("Invalid post ID, field key, or row index. postId: " . $postId . ", fieldKey: " . $fieldKey . ", rowIndex: " . $rowIndex);
            }
        }
    }

    wp_send_json_error("Invalid request.");
}

add_action("wp_ajax_multiple_update_repeater_items", "handle_multiple_update_repeater_items");
add_action("wp_ajax_nopriv_multiple_update_repeater_items", "handle_multiple_update_repeater_items");

function handle_multiple_update_repeater_items()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $postId = $_POST["postId"];
        $fieldKey = $_POST["fieldKey"];
        $titleFieldKey = isset($_POST["titleFieldKey"])
            ? sanitize_text_field($_POST["titleFieldKey"])
            : "";
        $colorFieldKey = isset($_POST["colorFieldKey"])
            ? sanitize_text_field($_POST["colorFieldKey"])
            : "";
        $fontFieldKey = isset($_POST["fontFieldKey"])
            ? sanitize_text_field($_POST["fontFieldKey"])
            : "";

        $rowIndex = isset($_POST["rowId"]) ? intval($_POST["rowId"]) : 0;
        $color = isset($_POST["color"])
            ? sanitize_hex_color($_POST["color"])
            : "";
        $title = isset($_POST["title"])
            ? sanitize_textarea_field($_POST["title"])
            : "";
        $font = isset($_POST["font"])
            ? sanitize_textarea_field($_POST["font"])
            : "";
        $type = isset($_POST["type"])
            ? sanitize_text_field($_POST["type"])
            : "";

        // Check if the file was uploaded successfully
        if ($postId > 0 && !empty($fieldKey) && $rowIndex > 0) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Update the specified fields in the repeater row
            if ($rowIndex <= count($repeaterFieldValues)) {
                if ($type == "color") {
                    if ($title !== "") {
                        $repeaterFieldValues[$rowIndex - 1][
                            $titleFieldKey
                        ] = $title;
                    } else {
                        wp_send_json_error("Title empty.");
                    }

                    if ($color !== "") {
                        $repeaterFieldValues[$rowIndex - 1][
                            $colorFieldKey
                        ] = $color;
                    } else {
                        wp_send_json_error("Color empty.");
                    }
                } elseif ($type == "font") {
                    if ($title !== "") {
                        $repeaterFieldValues[$rowIndex - 1][
                            $titleFieldKey
                        ] = $title;
                    } else {
                        wp_send_json_error("Title empty.");
                    }

                    if ($font !== "") {
                        $repeaterFieldValues[$rowIndex - 1][
                            $fontFieldKey
                        ] = $font;
                    } else {
                        wp_send_json_error("Font value empty.");
                    }
                }

                update_field($fieldKey, $repeaterFieldValues, $postId);

                // Send a success response
                wp_send_json_success(
                    "Fields updated in repeater row successfully!"
                );
            } else {
                // Invalid row index
                wp_send_json_error("Invalid row index. (PHP)");
            }
        } else {
            // Invalid post ID, field key, or row index
            wp_send_json_error(
                "Invalid post ID, field key, or row index. (PHP)"
            );
        }
    }

    wp_send_json_error("Invalid request.");
}

add_action("wp_ajax_remove_file_from_field", "handle_remove_file_from_field");
add_action(
    "wp_ajax_nopriv_remove_file_from_field",
    "handle_remove_file_from_field"
);

function handle_remove_file_from_field()
{
    // Check if the request is a valid POST request
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $postId = isset($_POST["postId"]) ? intval($_POST["postId"]) : 0;
        $fieldKey = isset($_POST["fieldKey"])
            ? sanitize_text_field($_POST["fieldKey"])
            : "";
        $filename = isset($_POST["fileName"])
            ? sanitize_text_field($_POST["fileName"])
            : "";

        // Check if the post ID and field key are valid
        if ($postId > 0 && !empty($fieldKey)) {
            // Update the ACF file field with null or an empty string
            update_field($fieldKey, null, $postId);
            removeNotification($filename);

            // Send a success response
            wp_send_json_success("File removed successfully!");
        } else {
            // Invalid post ID or field key
            wp_send_json_error("Invalid post ID or field key.");
        }
    }

    wp_send_json_error("Invalid request.");
}

add_action("wp_ajax_add_repeater_row", "handle_add_repeater_row");
add_action("wp_ajax_nopriv_add_repeater_row", "handle_add_repeater_row");

function handle_add_repeater_row()
{
    // Check if the request is a valid POST request
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $postId = isset($_POST["postId"]) ? intval($_POST["postId"]) : 0;
        $fieldKey = isset($_POST["fieldKey"])
            ? sanitize_text_field($_POST["fieldKey"])
            : "";

        // Check if the post ID and field key are valid
        if ($postId > 0 && !empty($fieldKey)) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Add a new row to the repeater field
            $newRow = ["column1" => "New Value 1", "column2" => "New Value 2"];
            $repeaterFieldValues[] = $newRow;

            // Update the ACF repeater field
            update_field($fieldKey, $repeaterFieldValues, $postId);

            wp_send_json_success([
                "message" => "Row added to repeater field successfully",
            ]);
        } else {
            // Invalid post ID or field key
            wp_send_json_error("Invalid post ID or field key.");
        }
    }

    wp_send_json_error("Invalid request.");
}

add_action("wp_ajax_update_repeater_row", "handle_update_repeater_row");
add_action("wp_ajax_nopriv_update_repeater_row", "handle_update_repeater_row");

function handle_update_repeater_row()
{
    // Check if the request is a valid POST request
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $postId = isset($_POST["postId"]) ? intval($_POST["postId"]) : 0;
        $fieldKey = isset($_POST["fieldKey"])
            ? sanitize_text_field($_POST["fieldKey"])
            : "";
        $rowIndex = isset($_POST["rowId"]) ? intval($_POST["rowId"]) : -1;

        // Check if the post ID, field key, and row index are valid
        if ($postId > 0 && !empty($fieldKey) && $rowIndex >= 0) {
            // Get the existing repeater field values
            $repeaterFieldValues = get_field($fieldKey, $postId);

            // Update the values for the specified row
            $repeaterFieldValues[$rowIndex] = [
                /* your updated field values for the row */
            ];

            // Update the ACF repeater field
            update_field($fieldKey, null, $postId);

            // Send a success response
            wp_send_json_success("Row in repeater field updated successfully!");
        } else {
            // Invalid post ID, field key, or row index
            wp_send_json_error("Invalid post ID, field key, or row index.");
        }
    }

    wp_send_json_error("Invalid request.");
}

add_action("wp_ajax_delete_repeater_row", "handle_delete_repeater_row");
add_action("wp_ajax_nopriv_delete_repeater_row", "handle_delete_repeater_row");

function handle_delete_repeater_row()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';
        $rowId = isset($_POST['rowId']) ? intval($_POST['rowId']) : 0;
        $filename = isset($_POST['fileName']) ? sanitize_text_field($_POST['fileName']) : '';

        if ($postId > 0 && !empty($fieldKey) && $rowId > 0) {
            $repeaterFieldValues = get_field($fieldKey, $postId);

            if ($rowId <= count($repeaterFieldValues)) {
                removeNotification($filename);
                delete_row($fieldKey, $rowId, $postId);
                wp_send_json_success("Row removed from repeater field successfully!");
            } else {
                wp_send_json_error("Invalid row index.");
            }
        } else {
            wp_send_json_error("Invalid post ID, field key, or row index.");
        }
    }

    wp_send_json_error("Invalid request.");
}

add_action("wp_ajax_add_images_to_gallery", "handle_add_images_to_gallery");
add_action("wp_ajax_nopriv_add_images_to_gallery", "handle_add_images_to_gallery");

function handle_add_images_to_gallery()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $gallery_field_key = isset($_POST['field_key']) ? sanitize_text_field($_POST['field_key']) : '';
        $row_id = isset($_POST['row_id']) ? intval($_POST['row_id']) - 1 : null;
        $current_year = date('Y');
        $current_month = date('m');
        $post = get_post($post_id);
        $post_name = $post->post_name;

        $upload_dir = wp_upload_dir();
        $post_folder_path = $upload_dir['basedir'] . '/' . $post_name;
        $year_month_folder_path = $post_folder_path . '/' . $current_year . '/' . $current_month;

        if (!file_exists($year_month_folder_path)) {
            mkdir($year_month_folder_path, 0755, true);
        }

        $files = $_FILES[$_POST['name_field']];

        if ($post_id > 0) {
            if (!empty($files['name'][0])) {
                $attach_ids = [];

                if (acf_get_field($gallery_field_key)['name'] == 'room_gallery') {
                    $rows = get_field('rooms', $post_id);
                    $specific_row = $rows[$row_id];
                    $current_gallery = $specific_row[acf_get_field($gallery_field_key)['name']];
                } else {
                    $current_gallery = get_field($gallery_field_key, $post_id);
                }

                if ($current_gallery && is_array($current_gallery)) {
                    $attach_ids = $current_gallery;
                }

                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/media.php';
                require_once ABSPATH . 'wp-admin/includes/image.php';

                foreach ($files['name'] as $key => $value) {
                    if ($files['name'][$key]) {
                        $file = [
                            'name' => $files['name'][$key],
                            'type' => $files['type'][$key],
                            'tmp_name' => $files['tmp_name'][$key],
                            'error' => $files['error'][$key],
                            'size' => $files['size'][$key],
                        ];

                        $_FILES = [$_POST['name_field'] => $file];

                        $attach_id = media_handle_upload($_POST['name_field'], $post_id);

                        if (is_wp_error($attach_id)) {
                            wp_send_json_error('Upload failed: ' . $attach_id->get_error_message());
                            continue;
                        }

                        $file_path = get_attached_file($attach_id);
                        $destination = $year_month_folder_path . '/' . basename($file_path);

                        if (rename($file_path, $destination)) {
                            update_attached_file($attach_id, $destination);

                            $metadata = wp_generate_attachment_metadata($attach_id, $destination);
                            wp_update_attachment_metadata($attach_id, $metadata);

                            $attach_ids[] = $attach_id;
                        } else {
                            wp_send_json_error('Failed to move file.');
                        }
                    }
                }

                if (acf_get_field($gallery_field_key)['name'] != 'room_gallery' && acf_get_field($gallery_field_key)['name'] != 'gallery') {
                    $existing_gallery = get_field($gallery_field_key, $post_id);
                    if ($existing_gallery && is_array($existing_gallery)) {
                        $attach_ids = array_merge($existing_gallery, $attach_ids);
                    }
                    update_field($gallery_field_key, $attach_ids, $post_id);
                } else {
                    if(acf_get_field($gallery_field_key)['name'] == 'room_gallery') {
                        $gallery = 'rooms';
                    }
                    
                    if(acf_get_field($gallery_field_key)['name'] == 'gallery') {
                        $gallery = 'custom_gallery';
                    }
                    
                    $rows = get_field($gallery, $post_id);
                    $existing_gallery = $rows[$row_id][$gallery_field_key];
                    if ($existing_gallery && is_array($existing_gallery)) {
                        $attach_ids = array_merge($existing_gallery, $attach_ids);
                    }
                    $rows[$row_id][$gallery_field_key] = $attach_ids;

                    update_field($gallery, $rows, $post_id);
                }

                $imageUrls = array_map('wp_get_attachment_url', $attach_ids);

                wp_send_json_success(['imageUrls' => $imageUrls, 'attach_ids' => $attach_ids], 'Images added to the gallery successfully!');
            } else {
                wp_send_json_error('No images uploaded.');
            }
        } else {
            wp_send_json_error('Invalid post ID.');
        }
    } else {
        wp_send_json_error('Invalid request method.');
    }
}

add_action("wp_ajax_delete_gallery_image", "handle_delete_gallery_image");
add_action("wp_ajax_nopriv_delete_gallery_image", "handle_delete_gallery_image");

function handle_delete_gallery_image()
{
    if (isset($_POST['image_id']) && isset($_POST['post_id']) && isset($_POST['field_key'])) {
        $image_id = intval($_POST['image_id']);
        $post_id = intval($_POST['post_id']);
        $field_key = sanitize_text_field($_POST['field_key']);

        if(!isset($_POST['repeater_field_key'])) {
            $images = get_field($field_key, $post_id);

            if ($images) {
                foreach ($images as $key => $image) {
                    if ($image["ID"] == $image_id) {
                        unset($images[$key]);
                        break;
                    }
                }

                $images = array_values($images);

                update_field($field_key, $images, $post_id);

                wp_send_json_success("Image deleted successfully!");
            } else {
                wp_send_json_error("No images found.");
            }
        } else {
            $repeater_field_key = sanitize_text_field($_POST['repeater_field_key']);
            $row_id = intval($_POST['row_id']);

            $rows = get_field(acf_get_field($repeater_field_key)['name'], $post_id);
            $rows[$row_id - 1][$field_key] = [];
            update_field(acf_get_field($repeater_field_key)['name'], $rows, $post_id);

            $images = get_field(acf_get_field($repeater_field_key)['name'], $post_id);
            if ($images) {
                foreach ($images as $key => $image) {
                    if ($image["ID"] == $image_id) {
                        unset($images[$key]);
                        break;
                    }
                }

                $images = array_values($images);

                update_field($images[$row_id - 1][$field_key], $images, $post_id);

                wp_send_json_success("Image deleted successfully!");
            } else {
                wp_send_json_error("No images found.");
            }
        }
    } else {
        wp_send_json_error("Invalid request.");
    }
}

add_action("wp_ajax_empty_gallery_field", "handle_empty_gallery_field");
add_action("wp_ajax_nopriv_empty_gallery_field", "handle_empty_gallery_field");

function handle_empty_gallery_field()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $fieldKey = isset($_POST['fieldKey']) ? sanitize_text_field($_POST['fieldKey']) : '';
        $repeater_field_key = isset($_POST['repeater_field_Key']) ? sanitize_text_field($_POST['repeater_field_Key']) : '';
        $row_id = isset($_POST['row_id']) ? intval($_POST['row_id']) : '';
        $gallery_field_key = acf_get_field($fieldKey)['key'];
        
        if ($post_id > 0) {
            if(!empty($repeater_field_key)) {
                $rows = get_field(acf_get_field($repeater_field_key)['name'], $post_id);
                $rows[$row_id - 1][$gallery_field_key] = [];
                update_field(acf_get_field($repeater_field_key)['name'], $rows, $post_id);
            } else {
                wp_send_json_error('Invalid repeater field key.');
            }

            if(!empty($fieldKey)) {
                update_field($gallery_field_key, [], $post_id);
            } else {
                wp_send_json_error('Invalid field key.');
            }
            wp_send_json_success('Gallery field emptied successfully!');
        } else {
            wp_send_json_error('Invalid post ID.');
        }
    } else {
        wp_send_json_error('Invalid request method.');
    }
}

if (!function_exists("wp_handle_upload")) {
    require_once ABSPATH . "wp-admin/includes/file.php";
}

function my_handle_attachment($file_handler, $post_id, $set_thu = false)
{
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]["error"] !== UPLOAD_ERR_OK) {
        __return_false();
    }

    require_once ABSPATH . "wp-admin" . "/includes/image.php";
    require_once ABSPATH . "wp-admin" . "/includes/file.php";
    require_once ABSPATH . "wp-admin" . "/includes/media.php";

    $attach_id = media_handle_upload($file_handler, $post_id);
    if (is_numeric($attach_id)) {
        update_post_meta($post_id, "_my_file_upload", $attach_id);
    }
    return $attach_id;
}

add_action("wp_ajax_ajax_search", "ajax_search_callback");
add_action("wp_ajax_nopriv_ajax_search", "ajax_search_callback");
function ajax_search_callback()
{
    $search_query = sanitize_text_field($_POST["search"]);
    $args = [
        "post_type" => "notifications",
        "s" => $search_query,
        "posts_per_page" => -1,
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $hotel = explode("/", get_the_content())[0];
            $section = strtolower(
                str_replace(" ", "-", explode("/", get_the_content())[1])
            );

            echo '<div class="notifications__item">
                <figure>
                    <span></span>
                    <span></span>
                </figure>
                <article data-user="' .
                (!empty(wp_get_current_user()->user_firstname)
                    ? wp_get_current_user()->user_firstname
                    : wp_get_current_user()->display_name) .
                '"><a href="' .
                get_home_url() .
                "/hotels/" .
                $hotel .
                "/#" .
                $section .
                '" title="' .
                get_the_title() .
                '">' .
                get_the_title() .
                '</a></article>
            </div>';
        }
    } else {
        echo "No results found";
    }
    wp_reset_postdata();
    die();
}

function get_file_icon($url)
{
    $icon = "";
    if (!empty($url)) {
        $info = new SplFileInfo($url);
        switch ($info->getExtension()) {
            case "pdf":
                $color = "#fc5f4c";
                break;
            case "xls":
            case "xlsx":
            case "xlsm":
                $color = "#107c41";
                break;
            case "docx":
            case "doc":
                $color = "#285395";
                break;
            default:
                $color = "#434343";
        }
        $icon =
            '<figure>
                <svg id="eB0JEjPqx6d1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 49" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">
                    <path d="M4.615079,2.653579L27.5022,2.570655l8.872906,10.531393v32.920968h-31.760027v-43.369437Z" fill="none" stroke="#434343" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M26.38157,2.570652v10.531393h9.993536L27.5022,2.570652h-1.12063Z" transform="translate(0 0.000003)" fill="#434343" stroke="#434343" stroke-width="0.5" stroke-linejoin="round"/>
                    <path d="M2.031101,24.296836L31.958601,24.5v14.422172h-29.9275v-14.625336Z" fill="' .
            $color .
            '" stroke="' .
            $color .
            '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </figure>';
    }
    return $icon;
}

function get_service_url($url, $post_id)
{
    if (!empty($url)) {
        $path_parts = explode("/", $url);
        $uploads_index = array_search("uploads", $path_parts);
        $new_path_parts = array_merge(
            array_slice($path_parts, 0, $uploads_index + 1),
            [get_post_field("post_name", $post_id)],
            array_slice($path_parts, $uploads_index + 1)
        );
        return implode("/", $new_path_parts);
    }
    return "";
}

function render_file_row($service, $x, $post_id, $field_key, $file_field_key)
{
    $icon = get_file_icon($service["url"]);
    $service_url = $service["url"];

    echo '<div data-row-index="' .
        $x .
        '" data-post-id="' .
        $post_id .
        '" data-field-key="' .
        $field_key .
        '" data-file-field-key="' .
        $file_field_key .
        '" class="table__row">
        <span class="table__row-title">' .
        $icon .
        $service["filename"] .
        '</span>
        <div class="table__row-controls">
            <button class="table__row-controls-view" data-url="' .
        $service_url .
        '">View</button>
            <button class="table__row-controls-delete">Remove</button>
            <button class="table__row-controls-share"><span class="material-symbols-outlined">share</span></button>
        </div>
    </div>';
}

function render_empty_file_row($x, $post_id, $field_key, $file_field_key)
{
    echo
    '<div data-row-index="' . $x . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-file-field-key="' . $file_field_key . '" class="table__row">
        <span class="table__row-title"></span>
        <div class="table__row-form">
            <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-file-field-key="' . $file_field_key . '" class="file-field" enctype="multipart/form-data">
                <input type="file" class="file" id="file" accept=".xls, .xlsm, .pdf, .docx">
                <button type="button" class="table__row-upload table__row-upload--repeater">Upload file</button>
            </form>
        </div>
        <div class="table__row-controls">
            <button class="table__row-controls-delete">Remove</button>
        </div>
    </div>';
}

function show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, $model)
{
    $output = "";
    $field_key = acf_get_field($field_name)["key"];
    if (!empty(acf_get_field($subfield_name)["key"])) {
        $file_field_key = acf_get_field($subfield_name)["key"];
    }

    $rows = get_field($field_name, $post_id);
    ob_start();
    ?>
    <div class="card__header">
        <h3><?= $section_title ?></h3>
    </div>
    <div class="card__body">
        <?php
        if ($model == "") {
            echo '<div class="table"><div class="table__header"></div><div class="table__body">';
            if ($rows):
                $x = 1;
                foreach ($rows as $row):
                    $service = $row[$subfield_name];
                    if (!empty($service)) {
                        render_file_row($service, $x, $post_id, $field_key, $file_field_key);
                    } else {
                        render_empty_file_row($x, $post_id, $field_key, $file_field_key);
                    }
                    $x++;
                endforeach;
            endif;
            echo
            '</div>
            <div class="table__foot">
                <span class="table__foot-addrow" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-file-field-key="' . $file_field_key . '">Add ' . $repeater_title . '</span>
                </div>
            </div>';
        }

        if ($model == "single") {
            if (!empty(get_field($field_name, $post_id))) {
                $filename = get_field($field_name, $post_id)["filename"];
                $url = get_field($field_name, $post_id)["url"];
                $key = acf_get_field($field_name)["key"];
                $icon = get_file_icon($url);

                echo
                '<div class="table">
                    <div class="table__header"></div>
                    <div class="table__body">
                        <div data-post-id="' . $post_id . '" data-field-key="' . $key . '" class="table__row">
                            <span class="table__row-title">' . $icon . $filename . '</span>
                            <div class="table__row-controls">
                                <button class="table__row-controls-view" data-url="' . $url . '">View</button>
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
                                <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="file-field" enctype="multipart/form-data">
                                    <input type="file" class="file" id="file" accept=".xls, .xlsm, .pdf, .docx">
                                    <button type="button" class="table__row-upload">Upload file</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table__foot">
                        <span class="table__foot-submit">Submit File</span>
                    </div>
                </div>';
            }
        }

        if ($model == "colour") {
            $field_key = acf_get_field($field_name)["key"];
            $title_field_key = acf_get_field($field_name)["sub_fields"][0]["key"];
            $colour_field_key = acf_get_field($field_name)["sub_fields"][1]["key"];

            echo '<div class="table"><div class="table__header"></div><div class="table__body">';

            if (have_rows($field_name)):
                $x = 1;
                while (have_rows($field_name)):
                    the_row();
                    $title = get_sub_field("title");
                    $colour = get_sub_field("colour");

                    if (!empty($title)) {
                        echo
                        '<div data-row-index="' . $x . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '"  data-title-key="' . $title_field_key . '" data-colour-key="' . $colour_field_key . '" class="table__row">
                            <span class="table__row-title"><span><input type="text" class="title-field" placeholder="' . $title . '" value="' . $title . '" disabled>
                                <span class="table__row-colour color-field" style="background-color: ' . $colour . '"></span>
                            </span>
                            </span>
                            <div class="table__row-controls">
                                <button class="table__row-controls-delete">Remove</button>
                            </div>
                        </div>';
                    } else {
                        echo
                        '<div data-row-index="' . $x . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-colour-key="' . $colour_field_key . '" class="table__row">
                            <div class="table__row-form table__row-form--colour">
                                <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-colour-key="' . $colour_field_key . '">
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
                <div class="table__foot">
                    <span class="table__foot-addrow table__foot-addrow--colour" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-colour-key="' . $colour_field_key . '">Add ' . $repeater_title . '</span>
                </div>
            </div>';
        }

        if ($model == "font") {
            $field_key = acf_get_field($field_name)["key"];
            $title_field_key = acf_get_field($field_name)["sub_fields"][0]["key"];
            $font_field_key = acf_get_field($field_name)["sub_fields"][1]["key"];

            echo '<div class="table"><div class="table__header"></div><div class="table__body">';

            if (have_rows($field_name)):
                $x = 1;
                while (have_rows($field_name)):
                    the_row();
                    $title = get_sub_field("title");
                    $font = get_sub_field("font");

                    if (!empty($title)) {
                        echo
                        '<div data-row-index="' . $x . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-font-key="' . $font_field_key . '" class="table__row">
                            <span class="table__row-title">
                                <span>
                                    <strong>Font name:</strong> ' . $title . " <strong>
                                    Font family: </strong>" . $font . '
                                </span>
                            </span>
                            <div class="table__row-controls">
                                <button class="table__row-controls-delete">Remove</button>
                            </div>
                        </div>';
                    } else {
                        echo
                        '<div data-row-index="' . $x . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-font-key="' . $font_field_key . '" class="table__row">
                            <div class="table__row-form table__row-form--font">
                                <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-font-key="' . $font_field_key . '">
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
                <div class="table__foot">
                    <span class="table__foot-addrow table__foot-addrow--font" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" data-title-key="' . $title_field_key . '" data-font-key="' . $font_field_key . '">Add ' . $repeater_title . '</span>
                </div>
            </div>';
        }

        echo "</div></div>";

        $output = trim(ob_get_clean());
        return $output;
}

function show_gallery($post_id, $section_title, $field_name)
{
    $images = get_field($field_name, $post_id);
    $field_key = acf_get_field($field_name)['key'];
    $file_array = preg_replace("/[^a-zA-Z]+/", "", $section_title);
    $subfield_name_category = '';
    $subfield_name_gallery = '';

    if($field_name != 'rooms' && $field_name != 'custom_gallery') {
        echo
        '<div class="card__header"><h3>' . $section_title . '</h3></div>
            <div class="card__body">
                <div class="table table--gallery" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '">
                    <div class="table__header"></div>
                    <div class="table__body" data-simplebar>';

        if ($images):
            foreach ($images as $image):
                $image_title = $image["alt"];
                $image_url = $image["url"];
                $image_filename = $image["filename"];
                $image_id = $image["ID"];
    
                echo
                '<div class="table__row">
                    <span class="table__row-title">
                        <figure data-image-id="' . $image_id . '">
                            <img src="' . get_template_directory_uri() . '/assets/img/photo-icon.svg" alt="' . $image_title . '">
                        </figure> ' . $image_filename . '
                    </span>
                    <div class="table__row-controls">
                        <a href="' . $image_url . '" title="' . $image_title . '" target="_blank">View</a>
                        <span class="table__row-controls-delete" data-image-id="' . $image_id . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '">Remove</span>
                    </div>
                </div>';
            endforeach;
            echo
            '</div>
            <div class="table__modal">
                <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="gallery-field" enctype="multipart/form-data">
                    <input type="file" accept="image/*" name="' . $file_array . '[]" multiple required>
                    <button type="button" class="upload-gallery">Submit</button>
                </form>
            </div>
            <div class="table__foot">
                <span class="table__foot-back">Go back</span>
                <span class="table__foot-removeimages" data-field-key="' . $field_key . '">Remove images</span>
                <span class="table__foot-viewgallery">View in gallery</span>
                <span class="table__foot-addgallery">Upload new picture</span>
            </div>';
        else:
            echo '</div>
            <div class="table__modal">
                <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="gallery-field" enctype="multipart/form-data">
                    <input type="file" accept="image/*" name="' . $file_array . '[]" multiple required>
                    <button type="button" class="upload-gallery">Submit</button>
                </form>
            </div>
            <div class="table__foot">
                <span class="table__foot-back">Go back</span>
                <span class="table__foot-removeimages" data-field-key="' . $field_key . '">Remove images</span>
                <span class="table__foot-viewgallery">View in gallery</span>
                <span class="table__foot-addgallery">Upload new picture</span>
            </div>';
        endif;
        echo "</div></div></div>";
    } else {
        $repeater_field = $field_key;
        $field_key = acf_get_field($field_name)['sub_fields']['1']['key'];
        // $field_name = acf_get_field($field_name)['sub_fields']['1']['key'];
        // $subfield_name_category = acf_get_field($field_name)['sub_fields']['0']['name'];
        // $subfield_name_gallery = acf_get_field($field_name)['sub_fields']['1']['name'];
        // $images = get_field($subfield_name_gallery, $post_id);
        if( have_rows($field_name, $post_id) ):
            while( have_rows($field_name, $post_id) ) : the_row();
                $x = get_row_index();
                $category = get_sub_field(acf_get_field($field_name)['sub_fields']['0']['name']);
                $gallery = get_sub_field(acf_get_field($field_name)['sub_fields']['1']['name']);

                echo
                '<div class="card photos" id="rooms">
                    <div class="card__header"><h3>' . $category . '</h3></div>
                    <div class="card__body">
                        <div class="table table--gallery" data-post-id="' . $post_id . '" data-repeater-field-key="'.$repeater_field.'" data-field-key="' . $field_key . '" data-row="'.$x.'">
                            <div class="table__body" data-simplebar>';

                if ($gallery):
                    foreach ($gallery as $image):
                        $image_title = $image["alt"];
                        $image_url = $image["url"];
                        $image_filename = $image["filename"];
                        $image_id = $image["ID"];
            
                        echo
                        '<div class="table__row">
                            <span class="table__row-title">
                                <figure data-image-id="' . $image_id . '">
                                    <img src="' . get_template_directory_uri() . '/assets/img/photo-icon.svg" alt="' . $image_title . '">
                                </figure> ' . $image_filename . '
                            </span>
                            <div class="table__row-controls">
                                <a href="' . $image_url . '" title="' . $image_title . '" target="_blank">View</a>
                                <span class="table__row-controls-delete" data-image-id="' . $image_id . '" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '">Remove</span>
                            </div>
                        </div>';
                    endforeach;
                    echo
                    '</div>
                    <div class="table__modal">
                        <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="gallery-field" enctype="multipart/form-data">
                            <input type="file" accept="image/*" name="' . $file_array . '[]" multiple required>
                            <button type="button" class="upload-gallery">Submit</button>
                        </form>
                    </div>
                    <div class="table__foot">
                        <span class="table__foot-back">Go back</span>
                        <span class="table__foot-removecategory">Remove room category</span>
                        <span class="table__foot-removeimages" data-field-key="' . $field_key . '">Remove images</span>
                        <span class="table__foot-viewgallery">View in gallery</span>
                        <span class="table__foot-addgallery">Upload new picture</span>
                    </div>';
                else:
                    echo '</div>
                    <div class="table__modal">
                        <form method="post" data-post-id="' . $post_id . '" data-field-key="' . $field_key . '" class="gallery-field" enctype="multipart/form-data">
                            <input type="file" accept="image/*" name="' . $file_array . '[]" multiple required>
                            <button type="button" class="upload-gallery">Submit</button>
                        </form>
                    </div>
                    <div class="table__foot">
                        <span class="table__foot-back">Go back</span>
                        <span class="table__foot-removecategory">Remove room category</span>
                        <span class="table__foot-removeimages" data-field-key="' . $field_key . '">Remove images</span>
                        <span class="table__foot-viewgallery">View in gallery</span>
                        <span class="table__foot-addgallery">Upload new picture</span>
                    </div>';
                endif;
                echo "</div></div></div>";
            endwhile;
        endif;
    }
}

add_action("wp_ajax_add_room_category", "handle_add_room_category");
add_action("wp_ajax_nopriv_add_room_category", "handle_add_room_category");

function handle_add_room_category()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $post_id = isset($_POST["post_id"]) ? intval($_POST["post_id"]) : 0;
        $field_key = isset($_POST["field_key"]) ? sanitize_text_field($_POST["field_key"]) : "";
        $category = isset($_POST["category"]) ? sanitize_text_field($_POST["category"]) : "";
        
        if ($post_id > 0) {
            $category_field_key = acf_get_field($field_key)['sub_fields']['0']['key'];
            $value = array($category_field_key => $category);
            add_row($field_key, $value, $post_id);
            wp_send_json_success("Room category added!");
        } else {
            wp_send_json_error("Invalid post ID or field key.");
        }
    } else {
        wp_send_json_error("Invalid request method.");
    }
}

function removeNotification($filename)
{
    $query = new WP_Query([
        "post_type" => "notifications",
        "post_status" => "publish",
        "posts_per_page" => 1,
        "title" => $filename,
    ]);

    if ($query->have_posts()) {
        $post = $query->posts[0];
        $post_id = $post->ID;
    } else {
        $post_id = "";
    }

    wp_delete_post($post_id, true);
}

add_action("wp_ajax_edit_user_email", "handle_edit_user_email");
function handle_edit_user_email()
{
    if (isset($_POST["user_id"]) && isset($_POST["new_email"])) {
        $user_id = intval($_POST["user_id"]);
        $new_email = sanitize_email($_POST["new_email"]);

        if (email_exists($new_email)) {
            wp_send_json_error("Email already exists.");
        }

        $user_data = [
            "ID" => $user_id,
            "user_email" => $new_email,
        ];

        if (wp_update_user($user_data)) {
            wp_send_json_success("Email updated successfully!");
        } else {
            wp_send_json_error("Failed to update email.");
        }
    } else {
        wp_send_json_error("Invalid request.");
    }
}

add_action("wp_ajax_edit_user_password", "handle_edit_user_password");
function handle_edit_user_password()
{
    if (isset($_POST["user_id"]) && isset($_POST["new_password"])) {
        $user_id = intval($_POST["user_id"]);
        $new_password = $_POST["new_password"];

        wp_update_user([
            "ID" => $user_id,
            "user_pass" => $new_password,
        ]);

        wp_send_json_success("Password changed successfully!");
    } else {
        wp_send_json_error("Invalid request.");
    }
}

add_action('wp_ajax_profile_image_upload', 'handle_profile_image_upload');

function handle_profile_image_upload() {
    $user_id = get_current_user_id();
    $upload = wp_handle_upload($_FILES['profile_image'], array('test_form' => false));

    if (isset($upload['error'])) {
        wp_send_json_error(array('message' => 'Error: ' . $upload['error']));
    } else {
        $filename = $upload['file'];
        $filetype = wp_check_filetype($filename);
        $attachment = array(
            'guid' => $upload['url'],
            'post_mime_type' => $filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $filename);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
        wp_update_attachment_metadata($attach_id, $attach_data);

        update_user_meta($user_id, 'profile_image', $upload['url']);

        wp_send_json_success(array('image_url' => $upload['url'], 'message' => 'Profile image uploaded successfully.'));
    }
    wp_die();
}

function custom_user_avatar($avatar, $id_or_email, $size, $default, $alt) {
    if (is_numeric($id_or_email)) {
        $user_id = (int) $id_or_email;
    } elseif (is_object($id_or_email)) {
        if (!empty($id_or_email->user_id)) {
            $user_id = (int) $id_or_email->user_id;
        }
    } else {
        $user = get_user_by('email', $id_or_email);
        $user_id = $user ? $user->ID : '';
    }

    $custom_avatar = get_user_meta($user_id, 'profile_image', true);

    if ($custom_avatar) {
        $avatar = '<img src="' . esc_url($custom_avatar) . '" alt="' . esc_attr($alt) . '" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" />';
    }

    return $avatar;
}
add_filter('get_avatar', 'custom_user_avatar', 10, 5);

add_action("wp_ajax_create_new_ticket", "create_new_ticket");
add_action("wp_ajax_nopriv_create_new_ticket", "create_new_ticket");

function create_new_ticket()
{
    $ticket_title = sanitize_text_field($_POST["ticket_title"]);
    $ticket_content = sanitize_textarea_field($_POST["ticket_content"]);
    $ticket_category_slug = sanitize_text_field($_POST["ticket_category"]);
    $post_id = isset($_POST["post_id"]) ? intval($_POST["post_id"]) : 0;

    $clickup_api_token = 'pk_48787545_XGXTPIF1JZI88F2O3CDUZDMIQ1FGS5GO';
    $clickup_list_id = 901304034991;

    $task_data = [
        'name'        => $ticket_title,
        'description' => $ticket_content,
        'assignees'   => array(),
        'status'      => 'Open',
        'tags'        => array( get_field( 'hotel_code', $post_id ), $ticket_category_slug ),
    ];

    $response = wp_remote_post(
        'https://api.clickup.com/api/v2/list/'.$clickup_list_id.'/task',
        [
            'headers' => [
                'Authorization' => $clickup_api_token,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($task_data),
        ]
    );

    if (!is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        $response_code = wp_remote_retrieve_response_code($response);

        if ($response_code == 200) {
            $response_data = json_decode($response_body, true);
            $task_response_id = $response_data['id'];

            $post_task = array(
                'ID'           => $post_id,
                'post_excerpt' => $task_response_id,
            );
            wp_update_post( $post_task );

            wp_send_json_success('ClickUp task created successfully.');
        } else {
            wp_send_json_error('Error creating ClickUp task: ' . $response_body);
        }
    } else {
        wp_send_json_error(
            'Error creating ClickUp task: ' . $response->get_error_message()
        );
    }

    wp_die();
}

// THIS RENDERS THE IBE SALES INSIDE A TABLE

/*
function render_quarterly_sales_table() {
    // Define the static data for the table
    $data = [
        ['', 'Q1 2024', 'Q1 2023', 'Q1 2024 vs Q1 2023'],
        ['Chambres vendues (IBE)', '99', '160', '38%'],
        ['Revenus (IBE)', '€14,128.00', '€20,417.00', '30%'],
        ['Trafic site internet (total)', '5805', '5284', '9%']
    ];

    ob_start();
    ?>
    <div class="card card--large">
        <div class="card__header">
            <h4>Quarterly IBE Sales</h4>
        </div>
        <div class="card__body">
            <table id="quarterlySalesTable" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <?php foreach ($data[0] as $header) : ?>
                            <th style="padding:8px;border:1px solid #ddd;text-align:left;"><?php echo $header; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i < count($data); $i++) : ?>
                        <tr>
                            <?php foreach ($data[$i] as $cell) : ?>
                                <td style="padding:8px;border:1px solid #ddd;"><?php echo $cell; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('quarterly_sales', 'render_quarterly_sales_table');
*/

// THIS RENDERS THE IBE SALES INSIDE A CANVAS

/*
function render_quarterly_sales_canvas() {
    // Define the static data for the table
    $data = [
        ['', 'Q1 2024', 'Q1 2023', 'Q1 2024 vs Q1 2023'],
        ['Chambres vendues (IBE)', '99', '160', '38%'],
        ['Revenus (IBE)', '€14,128.00', '€20,417.00', '30%'],
        ['Trafic site internet (total)', '5805', '5284', '9%']
    ];

    ob_start();
    ?>
    <div class="card card--large">
        <div class="card__header">
            <h4>Quarterly IBE Sales</h4>
        </div>
        <div class="card__body">
            <canvas id="quarterlyIbeCanvas" width="600" height="200"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('quarterlyIbeCanvas');
            const ctx = canvas.getContext('2d');

            // Define the data for the table
            const data = <?php echo json_encode($data); ?>;

            const cellWidth = 130;
            const cellHeight = 40;
            const startX = 10;
            const startY = 10;
            const tableWidth = cellWidth * data[0].length;
            const tableHeight = cellHeight * data.length;

            ctx.font = '11px Arial'; // Set font style and size
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            // Colors
            const headerBgColor = '#f2f2f2';
            const rowBgColor = '#ffffff';
            const borderColor = '#ddd';
            const textColor = '#000000';

            // Draw the table grid and content
            for (let i = 0; i < data.length; i++) {
                for (let j = 0; j < data[i].length; j++) {
                    const x = startX + j * cellWidth;
                    const y = startY + i * cellHeight;

                    // Set background color
                    ctx.fillStyle = i === 0 ? headerBgColor : rowBgColor;
                    ctx.fillRect(x, y, cellWidth, cellHeight);

                    // Set text color
                    ctx.fillStyle = textColor;
                    ctx.fillText(data[i][j], x + cellWidth / 2, y + cellHeight / 2);

                    // Draw cell border
                    ctx.strokeStyle = borderColor;
                    ctx.strokeRect(x, y, cellWidth, cellHeight);
                }
            }
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('quarterly_sales_canvas', 'render_quarterly_sales_canvas');
*/

// Function to add emails to ACF repeater field
function add_emails_to_acf($hotel_code, $emails) {
    $args = array(
        'post_type' => 'hotels',
        'meta_query' => array(
            array(
                'key' => 'hotel_code',
                'value' => $hotel_code,
                'compare' => '='
            )
        )
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            delete_field('emails', $post_id);
            if (!empty($emails)) {
                foreach ($emails as $email) {
                    add_row('emails', array('email' => $email), $post_id);
                }
            }
        }
    }
    
    wp_reset_postdata();
}

$data = [
    ["code" => "DEAYL", "emails" => ["info@saarwein-hotel.de"]],
    ["code" => "DEFRI", "emails" => ["info@waldhotel-friedrichroda.de"]],
    ["code" => "DEGRA", "emails" => ["karsten@grashof.de"]],
    ["code" => "DEJOH", "emails" => ["info@johannishof.eu"]],
    ["code" => "DEKRO", "emails" => ["d.krolik@landhotelkrolik.de"]],
    ["code" => "DEIMP", "emails" => ["j.loew@loew.ag", "lars.beutler-vetter@imperial-ruegen.de"]],
    ["code" => "DEVAK", "emails" => ["j.loew@loew.ag"]],
    ["code" => "DEVIB", "emails" => ["j.loew@loew.ag"]],
    ["code" => "DERIN", "emails" => ["info@ringelsteiner-muehle.de"]],
    ["code" => "DESAA", "emails" => ["michael@saarschleife.eu", "desk@saarschleife.eu"]],
    ["code" => "DESCH", "emails" => ["info@hotelschneider.de"]],
    ["code" => "DESON", "emails" => ["i.adams@parkhotel-sonnenberg.de"]],
    ["code" => "DETHD", "emails" => ["woelki@stadthotel-roemerturm.de"]],
    ["code" => "BEAUB", "emails" => ["l.d@laurentdethier.be", "info@hotel-thermes.be"]],
    ["code" => "BEBON", "emails" => ["info@hotelbonhomme.be"]],
    ["code" => "BECOM", "emails" => ["info@hoteldescomtes.com"]],
    ["code" => "BEESP", "emails" => ["info@espritsain.be"]],
    ["code" => "BEFDS", "emails" => ["info@fontainedusabotier.be"]],
    ["code" => "BEHDP", "emails" => ["contact@hoteldespostes.eu"]],
    ["code" => "BEMYR", "emails" => ["info@lesmyrtilles.be", "michel@mcehi.net"]],
    ["code" => "BERHO", "emails" => ["lesrhodos@icloud.com"]],
    ["code" => "BEVDF", "emails" => ["info@hotel-thermes.be", "l.d@laurentdethier.be"]],
    ["code" => "LUBEAU", "emails" => ["sylvie@beau-sejour.lu", "bonjour@nid-gourmand.lu"]],
    ["code" => "LUBEI", "emails" => ["info@beimschlass.lu", "crowleykillian@gmail.com"]],
    ["code" => "LUCIG", "emails" => ["cigalon@pt.lu"]],
    ["code" => "LUESP", "emails" => ["fredfrey@pt.lu", "contact@hotel-esplanade.lu"]],
    ["code" => "LUHER", "emails" => ["fredfrey@pt.lu"]],
    ["code" => "LULPP", "emails" => ["contact@lepetitpoete.lu"]],
    ["code" => "LUTAN", "emails" => ["c.roemer@auxtanneriesdewiltz.com"]],
    ["code" => "LUPOS", "emails" => ["conrad@lepostillon.lu"]],
    ["code" => "CHELF", "emails" => ["info@elfe-apartments.ch"]],
    ["code" => "THANA", "emails" => ["dgm.joy@anantasila.com", "dgm.kayla@anantasila.com"]],
    ["code" => "THBHS", "emails" => ["r.benyasri@gmail.com", "info@baanhinsairesort.com"]],
    ["code" => "THROP", "emails" => ["r.benyasri@gmail.com", "artornben@gmail.com"]],
    ["code" => "THSSB", "emails" => ["r.benyasri@gmail.com", "artornben@gmail.com"]],
    ["code" => "THKHA", "emails" => ["md@khaolaklaguna.com", "rm@khaolaklaguna.com", "dos@khaolaklaguna.com"]],
    ["code" => "KHPAC", "emails" => ["ga@pacifichotel.com.kh", "e-commerce@pacifichotel.com.kh", "mm@pacifichotel.asia"]],
];

foreach ($data as $row) {
    $hotel_code = $row['code'];
    $emails = $row['emails'];
    add_emails_to_acf($hotel_code, $emails);
}

function send_email_on_post_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (get_post_type($post_id) != 'hotels') return;

    $emails = get_field('emails', $post_id);

    if (!empty($emails)) {
        $to = [];
        foreach ($emails as $email) {
            $to[] = $email['email'];
        }

        $subject = 'New Hotel Post Inserted';
        $message = "A new post with ID $post_id has been inserted. Here are the email addresses associated with it:\n\n";
        foreach ($to as $email) {
            $message .= $email . "\n";
        }
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        wp_mail($to, $subject, $message, $headers);
    }
}

add_action('save_post', 'send_email_on_post_save');