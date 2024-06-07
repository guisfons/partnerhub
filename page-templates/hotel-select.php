<?php

/**
 * Template Name: Hotel Select Page
 * Template Post Type: page
 *
 * @package UAU
 * @since 1.0.0
 */

get_header();
loadModulesCssForTemplate('hotel-select.min.css');
?>
<aside class="hotel-select__sidebar">
    <figure class="hotel-select__logo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotelier-logo.png" alt="RegiÔtels -- Hotelier"></figure>

    <article>
        <span>WELCOME, Hotelier</span>

        <p>Choose the Hotel you will work at today</p>
    </article>

    <!-- <div class="hotel-select__select">
        <label for="hotel-select">
            <select name="hotel-select" id="">
                <option value="" disabled selected>Choose a Hotel</option>
                <?php
                $args = array(
                    'post_type' => 'hotels',
                    'meta_query' => array(
                        array(
                            'key' => 'user',
                            'value' => get_current_user_id(),
                            'compare' => 'LIKE',
                        ),
                    ),
                );
                
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        
                        echo '<option value="'.get_the_title().'" data-url="'.get_permalink().'">'.get_the_title().' <strong>('.get_field('hotel_code').')</strong></option>';
                    }
                }

                wp_reset_postdata();
                ?>
            </select>
        </label>

        <button class="hotel-select__btn">Select</button>
    </div> -->

    <div class="hotel-select__container">
        <div class="hotel-select__selection">
            <span>Choose a Hotel</span>
            <div class="hotel-select__select" style="display: none;">
                <?php
                $args = array(
                    'post_type' => 'hotels',
                    'meta_query' => array(
                        array(
                            'key' => 'user',
                            'value' => get_current_user_id(),
                            'compare' => 'LIKE',
                        ),
                    ),
                );
                
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        
                        echo '<span data-url="'.get_permalink().'" data-title="'.get_the_title().'" data-selected>'.get_the_title().' <strong>('.get_field('hotel_code').')</strong></span>';
                    }
                }

                wp_reset_postdata();
                ?>
            </div>
        </div>
        <button class="hotel-select__btn">Select</button>
    </div>


</aside>
<?php

get_footer();
