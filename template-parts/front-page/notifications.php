<section class="card notifications">
    <h2>Notifications</h2>
    <input type="search" name="search" id="search" placeholder="Search">

    <div class="notifications__tasks">
        <?php
        $args = array(
            'post_type' => 'notifications',
            'posts_per_page' => 20,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            $x = 1;
            while ($query->have_posts()) {
                $query->the_post();
                $hotel = explode('<br/>', get_the_content())[0];
                $section = strtolower(str_replace(' ', '-', explode('<br/>', get_the_content())[1]));
                
                echo
                '<div class="notifications__item" style="--data-notification: '.$x.';">
                    <figure>
                        <span class="material-symbols-outlined">account_circle</span>
                    </figure>
                    <article data-user="'.(!empty(wp_get_current_user()->user_firstname) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name).'"><a href="'. get_home_url(). '/hotels/' . $hotel . '/#' . $section .'" title="'.get_the_title().'">'.get_the_title().'</a></article>
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