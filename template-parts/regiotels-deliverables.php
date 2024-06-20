<?php $post_id = get_queried_object_id(); ?>
<section data-content="monthly-dashboard-report" class="content">
	<h2>Revenue & Distribution</h2>

    <div class="card monthly-dashboard-report">
        <?php
        $section_title = 'Monthly Dashboard Report'; $repeater_title = 'Monthly Dashboard Report'; $field_name = 'monthly_reports_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="pricing-structure" class="content">
    <h2>Revenue & Distribution</h2>

    <div class="card pricing-structure">
        <?php
        $section_title = 'Pricing Structure'; $repeater_title = 'Pricing Structure'; $field_name = 'pricing_structure_document'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="calendars" class="content">
    <h2>Revenue & Distribution</h2>

    <div class="card calendars">
        <?php
        $section_title = 'Calendars'; $repeater_title = 'Calendars'; $field_name = 'calendar'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="pickup-report" class="content">
    <h2>Revenue & Distribution</h2>

    <div class="card pickup-report">
        <?php
        $section_title = 'Pickup Report'; $repeater_title = 'Pickup Report'; $field_name = 'pickup_report_document'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="marketing-suggestions" class="content">
	<h2>Digital Marketing</h2>

    <div class="card marketing-suggestions">
        <?php
        $section_title = 'Marketing Suggestions'; $repeater_title = 'Marketing Suggestions'; $field_name = 'marketing_suggestions_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="web-traffic-analytics-dashboard" class="content">
	<h2>Digital Marketing</h2>

    <div class="card web-traffic-analytics-dashboard">
        <?php
        $section_title = 'Web Traffic Analytics Dashboard'; $repeater_title = 'Web Traffic Analytics Dashboard'; $field_name = 'web_traffic_analytics_dashboard_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="seo-review" class="content">
	<h2>Digital Marketing</h2>

    <div class="card seo-review">
        <?php
        $section_title = 'SEO Review'; $repeater_title = 'SEO Reviews'; $field_name = 'seo_review_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="social-media-posts" class="content">
	<h2>Digital Marketing</h2>

    <div class="card social-media-posts">
        <?php
        $section_title = 'Social Media Posts'; $repeater_title = 'Social Media Posts'; $field_name = 'social_media_posts_documents'; $subfield_name = 'file';
        echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
        ?>
    </div>
</section>

<section data-content="webaudit-report" class="content">
	<h2>Digital Marketing</h2>

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