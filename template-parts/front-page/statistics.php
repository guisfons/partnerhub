<div class="card card--statistics">
    <div class="card__header"><h4>Statistics of the Month</h4></div>
    <div class="card__body">
        <figure><canvas id="monthlyRoomSoldChart1" width="400" height="400"></canvas></figure>
        <figure><canvas id="monthlyOccupancyChart1" width="400" height="400"></canvas></figure>
        <figure><canvas id="monthlyAdrChart1" width="400" height="400"></canvas></figure>
        <figure><canvas id="monthlyRoomRev1" width="400" height="400"></canvas></figure>
        <figure><canvas id="monthlyRevPar1" width="400" height="400"></canvas></figure>
        <?php if (get_field('hotel_code') != 'THANA' || have_rows('los_data')) : ?>
            <figure><canvas id="monthlyLosChart1" width="400" height="400"></canvas></figure>
        <?php endif; ?>
    </div>
</div>