<?php $post_id = get_the_ID(); ?>
<section data-content="contract" class="content">
    <h2>General Info</h2>
    <div class="card contract">
        <?php
        $section_title = 'Contract'; $repeater_title = ''; $field_name = 'contract'; $subfield_name = '';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, '', 'single');
        ?>
    </div>
</section>

<section data-content="offers" class="content">
    <h2>General Info</h2>
    <div class="card offers">
        <?php
        $section_title = 'Offers'; $repeater_title = ''; $field_name = 'offers'; $subfield_name = '';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, '', 'single');
        ?>
    </div>
</section>

<section data-content="a-la-carte-services" class="content">
    <h2>General Info</h2>
    <div class="card lacarteservices">
        <?php
        $section_title = 'A La Carte Services'; $repeater_title = 'Services'; $field_name = 'la_carte_services'; $subfield_name = 'service_carte';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="invoices" class="content">
    <h2>General Info</h2>
    <div class="card invoices">
        <?php
        $section_title = 'Invoices'; $repeater_title = 'Invoices'; $field_name = 'invoices'; $subfield_name = 'invoice';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>