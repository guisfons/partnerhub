<?php
if(!is_single()) {
    $post_id = 1166;
} else {
    $post_id = get_the_ID();
}
?>
<section data-content="revenue-distribution" class="content">
	<h2>Revenue & Distribution</h2>
    <div class="card revenue-distribution">
        <?php
        $section_title = 'Revenue & Distribution'; $repeater_title = 'Revenue & Distribution'; $field_name = 'revenue_document'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
    <div class="card pricing-structure">
        <?php
        $section_title = 'Pricing Structure'; $repeater_title = 'Pricing Structure'; $field_name = 'pricing_structure_document'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
    <div class="card calendars">
        <?php
        $section_title = 'Calendars'; $repeater_title = 'Calendars'; $field_name = 'calendar'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
    <div class="card pickup-report">
        <?php
        $section_title = 'Pickup Report'; $repeater_title = 'Pickup Report'; $field_name = 'pickup_report_document'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="digital-marketing" class="content">
	<h2>Digital Marketing</h2>

    <div class="card marketing-suggestions">
        <?php
        $section_title = 'Marketing Suggestions'; $repeater_title = 'Marketing Suggestions'; $field_name = 'marketing_suggestions_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>

    <div class="card web-traffic">
        <?php
        $section_title = 'Web Traffic Analytics Dashboard'; $repeater_title = 'Web Traffic Analytics Dashboard'; $field_name = 'web_traffic_analytics_dashboard_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>

    <div class="card seo">
        <?php
        $section_title = 'SEO Review'; $repeater_title = 'SEO Reviews'; $field_name = 'seo_review_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>

    <div class="card social-media">
        <?php
        $section_title = 'Social Media Posts'; $repeater_title = 'Social Media Posts'; $field_name = 'social_media_posts_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>

    <div class="card webaudit-report">
        <?php
        $section_title = 'Webaudit Report'; $repeater_title = 'Webaudit Report'; $field_name = 'webaudit_report_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="online-sales" class="content">
	<h2>Online Sales</h2>
    <div class="card online-sales">
        <?php
        $section_title = 'Online Sales'; $repeater_title = 'Online Sales'; $field_name = 'online_sales_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>