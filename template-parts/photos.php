<?php $post_id = get_the_ID(); ?>

<section data-content="photos" class="content">
    <h2>Property Info</h2>

    <div class="card photos" id="exterior-photos">
        <?php
        $section_title = 'Exterior Photos';
        $field_name = 'exterior';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>

    <div class="card photos" id="interior-photos">
        <?php
        $section_title = 'Interior Photos';
        $field_name = 'interior';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>

    <div class="card photos" id="bedroom-photos">
        <?php
        $section_title = 'Bedroom Photos';
        $field_name = 'bedrooms';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>

    <div class="card photos" id="restaurant-photos">
        <?php
        $section_title = 'Restaurant Photos';
        $field_name = 'restaurants';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>

    <div class="card photos" id="foods-drinks-photos">
        <?php
        $section_title = 'Foods & Drinks Photos';
        $field_name = 'food_&_drinks';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>

    <div class="card photos" id="bar-photos">
        <?php
        $section_title = 'Bar Photos';
        $field_name = 'bar';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>

    <div class="card photos" id="other-photos">
        <?php
        $section_title = 'Other Photos';
        $field_name = 'other';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>
</section>