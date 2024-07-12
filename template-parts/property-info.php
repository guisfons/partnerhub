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
        <?php
        $section_title = 'Logos';
        $field_name = 'corporate_identity_logos';
        show_gallery($post_id, $section_title, $field_name);
        ?>
    </div>
</section>

<?php get_template_part('template-parts/photos'); ?>