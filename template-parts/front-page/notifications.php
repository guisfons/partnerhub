<section class="card notifications">
    <h4>Notifications</h4>
    <input type="search" name="search" id="search" placeholder="Search">

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
                echo
                '<div class="notifications__item" style="--data-notification: '.$x.';">
                    <figure>
                        <span></span>
                        <span></span>
                    </figure>
                    <article>
                        <span class="notifications__author">'.get_the_author().'</span>';
                        if(is_singular('hotels')) {
                            echo '<button data-href="' . $section .'" class="notifications__file">'.$icon.get_the_title().'</button>';
                        } else {
                            echo '<a href="'. get_home_url(). '/hotels/' . $hotel . '/#' . $section .'" title="'.get_the_title().'" class="notifications__file">'.$icon.get_the_title().'</a>';
                        }
                echo
                        '<time datetime="'.get_the_date('Y | m | d - H:i').'" class="notifications__time">'.get_the_date('Y | m | d - H:i').'</time>
                    </article>
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