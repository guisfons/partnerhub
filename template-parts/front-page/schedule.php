<section class="card schedule">
    <h2>Schedule</h2>

    <div class="schedule__tasks">
        <?php
        $args = array(
            'post_type' => 'schedule',
            'posts_per_page' => 20,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $hotel = explode('<br/>', get_the_content())[0];
                $section = strtolower(str_replace(' ', '-', explode('<br/>', get_the_content())[1]));
                
                echo
                '<div class="schedule__item">
                    <figure>
                        <span class="material-symbols-outlined">account_circle</span>
                    </figure>
                    <article data-user="'.(!empty(wp_get_current_user()->user_firstname) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name).'"><a href="'. get_home_url(). '/hotels/' . $hotel . '/#' . $section .'" title="'.get_the_title().'">'.get_the_title().'</a></article>
                </div>';
            }
        } else {
        
            echo "No Schedule.";
        }
        
        // Restore original post data
        wp_reset_postdata();
        ?>
    </div>
</section>