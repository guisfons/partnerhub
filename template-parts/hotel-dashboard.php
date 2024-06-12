<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- <section data-content="administration" class="administration content">
<?php
    	$user = wp_get_current_user();
        if (in_array('contributor', (array) $user->roles)) :
    ?>
    <?php endif; ?>
</section> -->

<!--
    THIS DEMARKS DASHBOARDS FOR REVENUE MANAGEMENT
-->

<section data-content="monthly-dashboard" class="content content--row">
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

    <?php if (get_field('hotel_code') != 'THANA' || have_rows('los_data')) : ?>
    <div class="card card--medium">
        <div class="card__header">
            <h4>LOS (Online Sales) - April</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyLosChart" width="400" height="400"></canvas>
        </div>
    </div>
    <?php endif; ?>

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

</section>

<section data-content="year-to-date-dashboard" class="content content--row">
    <h2>Hotel Dashboard</h2>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Rooms Sold - Year to Date</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdRoomSoldChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Occupancy Rate - Year to Date</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdOccupancyChart" width="400" height="400"></canvas>
        </div>
    </div>

    <?php if (get_field('hotel_code') != 'THANA' || have_rows('los_data')) : ?>
    <div class="card card--medium">
        <div class="card__header">
            <h4>LOS (Online Sales) - Year to Date</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdLosChart" width="400" height="400"></canvas>
        </div>
    </div>
    <?php endif; ?>

    <div class="card card--medium">
        <div class="card__header">
            <h4>ADR - Year to Date</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdAdrChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>RevPAR - Year to Date</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdRevPar" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Room REV - Year to Date</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdRoomRev" width="400" height="400"></canvas>
        </div>
    </div>

</section>

<section data-content="monthly-channels-dashboard" class="content content--row">
    <h2>Hotel Dashboard</h2>

    <div class="card card--large">
		<div class="card__header">
			<h4>Monthly Channel Production</h4>
		</div>
		<div class="card__body">
            <canvas id="monthlyChannelProduction" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyRoomSoldChannel" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly ADR per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyAdrChannel" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly % Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyPerChannelType1" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly Revenue per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyRevenueChannel" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly % Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyPerChannelType2" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Monthly % Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="monthlyPercentageRoomChannel" width="400" height="400"></canvas>
        </div>
    </div>

</section>

<section data-content="year-to-date-channels-dashboard" class="content content--row">
    <h2>Hotel Dashboard</h2>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Year to Date Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdRoomSoldChannel" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Year to Date ADR per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdAdrChannel" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Year to Date % Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdPerChannelType1" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Year to Date Revenue per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdRevenueChannel" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Year to Date % Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdPerChannelType2" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Year to Date % Rooms Sold per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="ytdPercentageRoomChannel" width="400" height="400"></canvas>
        </div>
    </div>

</section>

<section data-content="full-year" class="content content--row">
    <h2>Hotel Dashboard</h2>

    <div class="card card--large">
		<div class="card__header">
			<h4>Rooms Sold - Full Year Dashboard</h4>
		</div>
		<div class="card__body">
            <canvas id="yearlyRoomsSoldChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--large">
		<div class="card__header">
			<h4>ADR - Full Year Dashboard</h4>
		</div>
		<div class="card__body">
            <canvas id="yearAdr" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--large">
		<div class="card__header">
			<h4>Room Rev - Full Year Dashboard</h4>
		</div>
		<div class="card__body">
            <canvas id="yearRev" width="400" height="400"></canvas>
        </div>
    </div>

    <?php if (get_field('hotel_code') != 'THANA' || have_rows('los_data')) : ?>
    <div class="card card--large">
		<div class="card__header">
			<h4>LOS - Full Year Dashboard</h4>
		</div>
		<div class="card__body">
            <canvas id="yearLos" width="400" height="400"></canvas>
        </div>
    </div>
    <?php endif; ?>
</section>

<!--
    THIS DEMARKS DASHBOARDS FOR WEBSITE DASHBOARD
-->

<section data-content="web-report" class="content content--row">
    <h2>Traffic Report</h2>

    <!--
    <div class="card card--ibestats">
        <div class="card__header">
            <h4>Quarterly IBE Stats</h4>
        </div>
        <div class="card__body">
            <canvas id="ibestats" width="400" height="200"></canvas>
        </div>
    </div>
    -->

    <!--
    <div class="card card--large">
    <div class="card__header">
        <h4>Quarterly IBE Sales</h4>
    </div>
    <div class="card__body">
        <table id="quarterlySalesTable" style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;"></th>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;">Q1 2024</th>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;">Q1 2023</th>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;">Q1 2024 vs Q1 2023</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:8px;border:1px solid #ddd;">Chambres vendues (IBE)</td>
                    <td style="padding:8px;border:1px solid #ddd;">99</td>
                    <td style="padding:8px;border:1px solid #ddd;">160</td>
                    <td style="padding:8px;border:1px solid #ddd;">38%</td>
                </tr>
                <tr>
                    <td style="padding:8px;border:1px solid #ddd;">Revenus (IBE)</td>
                    <td style="padding:8px;border:1px solid #ddd;">€14,128.00</td>
                    <td style="padding:8px;border:1px solid #ddd;">€20,417.00</td>
                    <td style="padding:8px;border:1px solid #ddd;">30%</td>
                </tr>
                <tr>
                    <td style="padding:8px;border:1px solid #ddd;">Trafic site internet (total)</td>
                    <td style="padding:8px;border:1px solid #ddd;">5805</td>
                    <td style="padding:8px;border:1px solid #ddd;">5284</td>
                    <td style="padding:8px;border:1px solid #ddd;">9%</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    -->

    <div class="card card--webtrafficperdays">
        <div class="card__header">
            <h4>Quarterly Website Traffic</h4>
        </div>
        <div class="card__body">
            <canvas id="trafficChartQ1" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--webtrafficchannelpie">
        <div class="card__header">
            <h4>Quarterly Traffic per Channel</h4>
        </div>
        <div class="card__body">
            <canvas id="trafficPieChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--trafficcomparison">
        <div class="card__header">
            <h4>Quarterly Traffic Comparison</h4>
        </div>
    <div class="card__body">
        <table id="trafficComparisonTable" style="width:100%;border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#25475C;color:#fff;">Traffic Channel</th>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#2E7C8A;color:#fff;">Visitors</th>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#5EC4C8;color:#fff;">Q1 24 vs Q1 23</th>
                    <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#5EC4C8;color:#fff;">Q1 24 vs Q4 23</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color:#f2f2f2;">
                    <td style="padding:8px;border:1px solid #ddd;">Direct</td>
                    <td style="padding:8px;border:1px solid #ddd;">2,210</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#3ca567;font-weight:bold">+1040</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-2,124</td>
                </tr>
                <tr style="background-color:#f2f2f2;">
                    <td style="padding:8px;border:1px solid #ddd;">Organic Search</td>
                    <td style="padding:8px;border:1px solid #ddd;">1,510</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-1807</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-1,696</td>
                </tr>
                <tr style="background-color:#f2f2f2;">
                    <td style="padding:8px;border:1px solid #ddd;">Referral</td>
                    <td style="padding:8px;border:1px solid #ddd;">1,292</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#3ca567;font-weight:bold">+1117</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-474</td>
                </tr>
                <tr style="background-color:#f2f2f2;">
                    <td style="padding:8px;border:1px solid #ddd;">Organic Social</td>
                    <td style="padding:8px;border:1px solid #ddd;">603</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-2</td>
                    <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-84</td>
                </tr>
                <tr style="background-color:#f2f2f2;">
                    <td style="padding:8px;border:1px solid #ddd;">Other</td>
                    <td style="padding:8px;border:1px solid #ddd;">190</td>
                    <td style="padding:8px;border:1px solid #ddd;font-weight:bold"></td>
                    <td style="padding:8px;border:1px solid #ddd;color:#3ca567;font-weight:bold">+37</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

</section>

<section data-content="ibe-sales" class="content content--row">
        <h2>IBE Sales</h2>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Rooms Sold (IBE) - Q1 Comparison</h4>
        </div>
        <div class="card__body">
            <canvas id="roomsSoldChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--medium">
        <div class="card__header">
            <h4>Revenue and Traffic - Q1 Comparison</h4>
        </div>
        <div class="card__body">
            <canvas id="revenueChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--ibestats">
        <div class="card__header">
            <h4>Quarterly IBE Sales</h4>
        </div>
        <div class="card__body">
            <table id="quarterlySalesTable" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#25475C;color:#fff">IBE Sales</th>
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#2E7C8A;color:#fff;">Q1 2024</th>
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#5EC4C8;color:#fff;">Q1 2023</th>
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;background-color:#5EC4C8;color:#fff;">Q1 2024 vs Q1 2023</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color:#f2f2f2;">
                        <td style="padding:8px;border:1px solid #ddd;">Rooms Sold (IBE)</td>
                        <td style="padding:8px;border:1px solid #ddd;">99</td>
                        <td style="padding:8px;border:1px solid #ddd;">160</td>
                        <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-38%</td>
                    </tr>
                    <tr style="background-color:#f2f2f2;">
                        <td style="padding:8px;border:1px solid #ddd;">Revenue (IBE)</td>
                        <td style="padding:8px;border:1px solid #ddd;">€14,128.00</td>
                        <td style="padding:8px;border:1px solid #ddd;">€20,417.00</td>
                        <td style="padding:8px;border:1px solid #ddd;color:#f67b6d;font-weight:bold">-30%</td>
                    </tr>
                    <tr style="background-color:#f2f2f2;">
                        <td style="padding:8px;border:1px solid #ddd;">Total Website Traffic</td>
                        <td style="padding:8px;border:1px solid #ddd;">5805</td>
                        <td style="padding:8px;border:1px solid #ddd;">5284</td>
                        <td style="padding:8px;border:1px solid #ddd;color:#3ca567;font-weight:bold">+9%</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
</section>

<section data-content="page-traffic" class="content content--row"> 
    <h2>Page Traffic</h2>

    <div class="card card--large">
        <div class="card__header">
            <h4>Page Traffic per Page - Q1 2024</h4>
        </div>
        <div class="card__body">
            <canvas id="pageTrafficChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="card card--large">
        <div class="card__header">
            <h4>Page Traffic per Room - Q1 2024</h4>
        </div>
        <div class="card__body">
            <canvas id="pageTrafficRoom" width="400" height="400"></canvas>
        </div>
    </div>
</section>

<section data-content="geo-traffic" class="content content--row"> 
    <h2>Geographic Traffic</h2>

    <div class="card card--geostats">
        <div class="card__header">
            <h4>Geographic Traffic - Q1 2024</h4>
        </div>
        <div class="card__body">
            <div id="regions_div"></div>
            <div id="table_div"></div>
        </div>
    </div>

    <div class="card card--geostats">
        <div class="card__header">
            <h4>Geographic Traffic - Q1 2023</h4>
        </div>
            <div class="card__body">
            <div id="regions_div2"></div>
            <div id="table_div2"></div>
        </div>
    </div>

    <div class="card card--geostats">
        <div class="card__header">
            <h4>Geographic Traffic - Q4 2023</h4>
        </div>
            <div class="card__body">
            <div id="regions_div3"></div>
            <div id="table_div3"></div>
        </div>
    </div>


</section>

<!--
    THIS DEMARKS DASHBOARDS FOR META ADS DASHBOARD
-->


<!--
    THIS DEMARKS DASHBOARDS FOR GOOGLE ADS DASHBOARD
-->