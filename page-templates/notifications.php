<?php

/**
 * Template Name: Notifications Page
 * Template Post Type: page
 *
 * @package UAU
 * @since 1.0.0
 */

get_header();
loadModulesCssForTemplate('notifications.min.css');
?>
<section class="content content--active">
    <h1>Notifications</h1>

    <div class="notifications__tasks">
        <?php

        $post = get_post(get_the_ID());

        if(is_singular('hotels')) {
            $content = $post->post_name;
        } else {
            $content = '';
        }

        $args = array(
            'post_type' => 'notifications',
            'posts_per_page' => 20,
            'orderby' => 'date',
            'order' => 'DESC',
            's' => $content,
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            $x = 1;
            while ($query->have_posts()) {
                $query->the_post();
                $hotel = explode('/', get_the_content())[0];
                $content_parts = explode('/', get_the_content());
                $section = '';

                if (isset($content_parts[1])) {
                    $section = strtolower(str_replace(' ', '-', $content_parts[1]));
                }
                
                $icon = get_file_icon(get_the_title());

                // $date = get_the_date('Y | m | d - H:i');

                $date = get_the_date('Y-m-d H:i:s');
                $now = new DateTime('now');
                $postDate = new DateTime($date);
                $interval = $now->diff($postDate);
                $time = '';

                if ($interval->days === 0) {
                    $time = 'recently uploaded a file';
                } else if ($interval->days === 1) {
                    $time = 'uploaded a file yesterday';
                } else if ($interval->days < 7) {
                    $time = 'uploaded a file ' . $interval->days . ' days ago';
                } else if ($interval->days < 30) {
                    if(floor($interval->days / 7) == '1') {
                        $time = 'uploaded a file ' . floor($interval->days / 7) . ' week ago';
                    } else {
                        $time = 'uploaded a file ' . floor($interval->days / 7) . ' weeks ago';
                    }
                } else if ($interval->y === 0) {
                    if($interval->format('%m') === '1') {
                        $time = 'uploaded a file ' . $interval->format('%m month ago');
                    } else {
                        $time = 'uploaded a file ' . $interval->format('%m months ago');
                    }
                } else if ($interval->y > 0) {
                    if ($interval->format('%y') === '1') {
                        $time = 'uploaded a file ' . $interval->format('%y year ago');
                    } else {
                        $time = 'uploaded a file ' . $interval->format('%y years ago');
                    }
                } else {
                    $time = 'uploaded a file on: ' . $postDate->format('Y | m | d - H:i');
                }

                echo
                '<div class="notifications__item">
                    <div class="notifications__item-content">
                        <figure>
                            <span></span>
                            <span></span>
                        </figure>
                        <article>
                            <span class="notifications__author">'.get_the_author().', ' . $time . '</span>';
                            if(is_singular('hotels')) {
                                echo '<button data-href="' . $section .'" class="notifications__file">'.$icon.get_the_title().'</button>';
                            } else {
                                echo '<a href="'. get_home_url(). '/hotels/' . $hotel . '/#' . $section .'" title="'.get_the_title().'" class="notifications__file">'.$icon.get_the_title().'</a>';
                            }
                echo
                            '<time datetime="'. get_the_date('Y | m | d - H:i') .'" class="notifications__time">'. get_the_date('Y | m | d - H:i') .'</time>
                        </article>
                    </div>
                </div>';
            }

            $x++;
        } else {
            echo "No notifications.";
        }
        
        // Restore original post data
        wp_reset_postdata();
        ?>
    </div>
</section>
<?php

get_footer();
