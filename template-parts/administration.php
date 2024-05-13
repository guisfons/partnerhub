<section data-content="administration" class="administration content">
    <?php if (!current_user_can('revenuemanager') || !current_user_can('headofoperations') || !current_user_can('digitalmarketing'))  : ?>
    <h2>Administration</h2>
    <div class="card administration__contact">
        <div class="card__header">
            <h3>RegiÔtels Team Contact Details</h3>
        </div>
        <div class="card__body">
            <?php
            $revenue_contact_id = get_field('revenue_contact');
            $revenue_contact_name = isset(get_userdata($revenue_contact_id)->first_name) ? get_userdata($revenue_contact_id)->first_name : '';
            $revenue_contact_last_name = isset(get_userdata($revenue_contact_id)->last_name) ? get_userdata($revenue_contact_id)->last_name : '';
            $revenue_contact_email = isset(get_userdata($revenue_contact_id)->user_email) ? get_userdata($revenue_contact_id)->user_email : '';

            if (have_rows('contacts', 'options')) :
                while (have_rows('contacts', 'options')) : the_row();
                    $area = get_sub_field('area');
                    $responsible = get_sub_field('responsible');

                    echo '<div class="administration__contact-area"><h4>' . $area . '</h4>';

                    if (!empty($revenue_contact_id) && $area == 'Revenue Management') {
                        echo '<p><span><strong>' . ucwords($revenue_contact_name . ' ' . $revenue_contact_last_name) . '</strong></span></p>';
                        echo '<p><a href="mailto:' . $revenue_contact_email . '" target="_blank">' . $revenue_contact_email . '</a></p>';
                    } else {
                        echo '<p><span><strong>' . $responsible . '</strong></span></p>';
                    }

                    if (have_rows('emails')) :
                        while (have_rows('emails')) : the_row();
                            $email = get_sub_field('email');
                            echo '<p><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></p>';
                        endwhile;
                    endif;

                    if (have_rows('contact_number')) :
                        while (have_rows('contact_number')) : the_row();
                            $number = get_sub_field('number');
                            echo '<p><a href="tel:+' . $number . '" target="_blank">+' . $number . '</a></p>';
                        endwhile;
                    endif;
                    echo '</div>';
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <?php endif; ?>
    <h2>Hotel Dashboard</h2>

    <div class="card card--noresize">
        <div class="card__header">
            <h3>Room Pricing Per Day</h3>
        </div>
        <div class="card__body">
            <?php
            global $wpdb;
            $results = $wpdb->get_results('SELECT partner_room_price, date FROM room_pricing_'.get_field('hotel_code').'');
            
            $data = [];
            foreach ($results as $row) {
                $data[] = array(
                    'label' => $row->date,
                    'value' => $row->partner_room_price
                );
            }
            $data_json = json_encode($data);
            echo '<script>let pricingPerDay = '.$data_json.';</script>';
            ?>
            <canvas id="pricingPerDayChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--noresize">
        <div class="card__header">
            <h3>Room Availability Per Day</h3>
        </div>
        <div class="card__body">
            <?php
            global $wpdb;
            $results = $wpdb->get_results('SELECT rooms_left, date FROM occupancy_rate_'.get_field('hotel_code').'');
            
            $data = [];
            foreach ($results as $row) {
                $data[] = array(
                    'label' => $row->date,
                    'value' => $row->rooms_left
                );
            }
            $data_json = json_encode($data);
            echo '<script>let availabilityPerDay = '.$data_json.';</script>';
            ?>
            <canvas id="availabilityPerDayChart" width="400" height="400"></canvas>
        </div>
    </div>
</section>