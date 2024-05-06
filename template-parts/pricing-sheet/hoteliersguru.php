<?php
$currentDate = new DateTime();
$weekOfMonth = ceil($currentDate->format('d') / 7);
?>
<section data-content="hoteliersguru" class="hoteliersguru content">
	<h2>HoteliersGuru</h2>
    <div class="card pricing-sheet__hq">
        <div class="card__header"><h3>HQ Rev Pricing Sheet</h3></div>
        <div class="card__body">
            
        </div>
    </div>
    <div class="card pricing-sheet__channel-manager">
        <div class="card__header"><h3>Channel Manager Occupancy Rate</h3></div>
        <div class="card__body">
            <h4>Week <?php echo $weekOfMonth; ?></h4>
        </div>
    </div>
    <div class="card pricing-sheet__hotel-pricing">
        <div class="card__header"><h3>Hotel Pricing Sheet</h3></div>
        <div class="card__body">
            
        </div>
    </div>
</section>