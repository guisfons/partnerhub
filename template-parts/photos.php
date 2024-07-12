<?php $post_id = get_the_ID(); ?>

<section data-content="photos" class="content">
    <h2>Property Info</h2>

    <?php
    $user = wp_get_current_user();
    $section_title = 'Custom gallery';
    $field_name = 'custom_gallery';
    $field_key = acf_get_field($field_name)['key'];
    $gallery_field_key = acf_get_field($field_name)['sub_fields']['1']['key'];
    ?>
    <div class="card custom-gallery" id="custom-gallery">
        <div class="card__header"><h3>Add Custom Gallery</h3></div>
        <div class="card__body">
            <div class="card__body-room">
                <input type="text" placeholder="Custom gallery Name">
                <span class="card__body-room-addroom card__body-room-addroom--custom" data-field-key="<?= $field_key; ?>" data-gallery-field-key="<?= $gallery_field_key; ?>" data-post-id="<?= $post_id; ?>">Submit</span>
            </div>
        </div>
    </div>

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

    <div class="content__customrooms">
        <?php
        $user = wp_get_current_user();
        $section_title = 'Custom gallery';
        $field_name = 'custom_gallery';
        $field_key = acf_get_field($field_name)['key'];
        $gallery_field_key = acf_get_field($field_name)['sub_fields']['1']['key'];

        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>
</section>

<section data-content="rooms" class="content">
    <h2>Rooms</h2>
    <?php
	$user = wp_get_current_user();
    $section_title = 'Rooms';
    $field_name = 'rooms';
    $field_key = acf_get_field($field_name)['key'];
    $gallery_field_key = acf_get_field($field_name)['sub_fields']['1']['key'];
    
    if(!in_array('contributor', (array) $user->roles)) {
    ?>
    <div class="card photos" id="rooms">
        <div class="card__header"><h3>Add Room Category</h3></div>
        <div class="card__body">
            <div class="card__body-room">
                <input type="text" placeholder="Room Category Name">
                <span class="card__body-room-addroom" data-field-key="<?= $field_key; ?>" data-gallery-field-key="<?= $gallery_field_key; ?>" data-post-id="<?= $post_id; ?>">Submit</span>
            </div>
        </div>
    </div>
    <?php
    }
    show_gallery($post_id, $section_title, $field_name);
    ?>
</section>