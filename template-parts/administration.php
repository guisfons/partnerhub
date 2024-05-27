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

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Rooms Sold - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyRoomSoldChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Occupancy Rate - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyOccupancyChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>LOS (Online Sales) - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyLosChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>ADR - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyAdrChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>RevPAR - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyRevPar" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Room REV - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyRoomRev" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyRoomChannel" width="400" height="400"></canvas>
        </div>
    </div>

</section>