<!-- <div class="card card--statistics">
    <div class="card__header"><h4>Statistics of the Month</h4></div>
    <div class="card__body">
    <?php if (get_field('hotel_code') == 'THANA' || get_field('hotel_code') == 'EXA') { ?>
            <figure><canvas id="monthlyRoomSoldChart1" width="400" height="400"></canvas></figure>
            <figure><canvas id="monthlyOccupancyChart1" width="400" height="400"></canvas></figure>
            <figure><canvas id="monthlyAdrChart1" width="400" height="400"></canvas></figure>
            <figure><canvas id="monthlyRoomRev1" width="400" height="400"></canvas></figure>
            <figure><canvas id="monthlyRevPar1" width="400" height="400"></canvas></figure>
        <?php } if (get_field('hotel_code') != 'THANA' || have_rows('los_data')) { ?>
            <figure><canvas id="monthlyLosChart1" width="400" height="400"></canvas></figure>
        <?php } ?>
    </div>
</div> -->
<?php $post_id = get_the_ID(); ?>
<div class="card card--medium monthly-dashboard-report">
    <?php
    $section_title = 'Monthly Dashboard Report'; $repeater_title = 'Monthly Dashboard Report'; $field_name = 'monthly_reports_documents'; $subfield_name = 'file';
    echo show_tables($post_id, $section_title, $repeater_title, $field_name, $subfield_name, '');
    ?>
</div>