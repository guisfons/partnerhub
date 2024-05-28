<?php $post_id = get_the_ID(); ?>
<section data-content="onboarding" class="content">
    <h2>Property Info</h2>

    <div class="card onboarding" id="onboarding">
        <?php
        $section_title = 'Onboarding';
        $repeater_title = 'Files';
        $field_name = 'onboarding';
        $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="menus" class="content">
    <h2>Property Info</h2>

    <div class="card menus">
        <?php
        $section_title = 'Menus';
        $repeater_title = 'Menus';
        $field_name = 'menus';
        $subfield_name = 'menu';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="texts" class="content">
    <h2>Property Info</h2>

    <div class="card texts">
        <?php
        $section_title = 'Texts';
        $repeater_title = 'Texts';
        $field_name = 'texts';
        $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>

</section>

<section data-content="facilities-services" class="content">
    <h2>Property Info</h2>

    <div class="card facilities-services">
        <?php
        $section_title = 'Facilities & Services';
        $repeater_title = 'Facilities & Services';
        $field_name = 'facilities_services';
        $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="corporate-identity" class="content">
    <h2>Property Info</h2>

    <div class="card corporate-identity">
        <?php
        $section_title = 'Colour';
        $repeater_title = 'Colour';
        $field_name = 'corporate_identity_colours';
        $subfield_name = 'title,colour';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, 'colour');
        ?>
    </div>

    <div class="card">
        <?php
        $section_title = 'Fonts';
        $repeater_title = 'Fonts';
        $field_name = 'corporate_identity_fonts';
        $subfield_name = 'title,font';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, 'font');
        ?>
    </div>

    <div class="card card--noresize">
        <div class="card__header"><h3>Logos</h3></div>
        <div class="gallery">
            <?php
            $images = get_field('corporate_identity_logos');
            $field_key = acf_get_field('corporate_identity_logos')['key'];

            if ($images) :
                echo '<div class="gallery__images gallery__images--noslider">';
                foreach ($images as $image) :
                    $image_title = $image['alt'];
                    $image_url = $image['url'];
                    $image_filename = $image['filename'];
                    echo '<figure><img src="' . $image_url . '" alt="' . $image_title . '"></figure>';
                endforeach;
                echo
                '</div>
                    <div class="gallery__control">
                        <span class="remove-images" data-field-key="' . $field_key . '">Remove images</span>
                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                        <form method="post" data-post-id="' . $post_id . '" enctype="multipart/form-data" data-field-key="' . $field_key . '" class="gallery-field">
                            <input type="file" accept="image/*" name="logos[]" multiple required>
                            <button type="button" class="upload-gallery">Submit</button>
                        </form>
                    </div>';
            else :
                echo
                '<div class="gallery__control">
                        <form method="post" data-post-id="' . $post_id . '" enctype="multipart/form-data" data-field-key="' . $field_key . '" class="gallery-field">
                            <input type="file" accept="image/*" name="logos[]" multiple required>
                            <button type="button" class="upload-gallery">Add Logos</button>
                        </form>
                    </div>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/photos'); ?>