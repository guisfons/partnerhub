<?php $user = wp_get_current_user(); ?>
<aside class="aside aside--active">
	<button class="aside__button"><span class="material-symbols-outlined"></span></button>
	<figure class="aside__logo"><img src="<?= get_template_directory_uri(); ?>/assets/img/logo.webp" alt="Logo">PartnerHub</figure>
	<div class="aside__container">
		<?php
		if (is_singular('hotels') || current_user_can('contributor')) {
			if(!current_user_can('contributor')) {
				echo '<button class="aside__item"><a href="'.get_home_url().'" title="Home">PartnerHub Home</a></button>';
			} else {
				echo '<button data-menu="home" class="aside__item">Home</button>';
			} ?>
			<button data-menu="administration" class="aside__item">Hotel Dashboard</button>
			<div class="aside__menu">
				<button class="aside__item">General Info <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="contract"><h4>Contract</h4></span>
					<span data-menu="offers"><h4>Offers</h4></span>
					<span data-menu="a-la-carte-services"><h4>A La Carte Services</h4></span>
					<span data-menu="invoices"><h4>Invoices</h4></span>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">Property Info <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="onboarding"><h4>Onboarding</h4></span>
					<span data-menu="corporate-identity"><h4>Corporate Identity</h4></span>
					<span data-menu="photos"><h4>Photos</h4></span>
					<span data-menu="menus"><h4>Menus</h4></span>
					<span data-menu="texts"><h4>Texts</h4></span>
					<span data-menu="facilities-services"><h4>Facilities & Services</h4></span>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">Deliverables <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="revenue-distribution"><h4>Revenue & Distribution</h4></span>
					<span data-menu="digital-marketing"><h4>Digital Marketing</h4></span>
					<span data-menu="online-sales"><h4>Online Sales</h4></span>
				</div>
			</div>
			<?php if (in_array('administrator', (array) $user->roles) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles)) : ?>
			<!-- <div class="aside__menu">
				<button class="aside__item">Revenue Automation <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="pricing-sheet"><h4>Pricing Sheet</h4></span>
					<span data-menu="room-pricing"><h4>Room Pricing</h4></span>
					<span data-menu="occupancy-rate"><h4>Occupancy Rate</h4></span>
				</div>
			</div> -->
			<?php
			endif;
			} else {
			if (in_array('administrator', (array) $user->roles) || in_array('editor', (array) $user->roles) || in_array('headofoperations', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles)) {
				$args = array(
					'post_type'      => 'hotels',
					'posts_per_page' => -1,
					'meta_key'       => 'country',
					'orderby'        => 'meta_value',
					'order'          => 'ASC',
				);

				$query = new WP_Query($args);

				if ($query->have_posts()) :
					echo '<div class="aside__menu"><button class="aside__item">Hotels Listing<span></span></button><nav class="aside__nav" style="display: none;">';

					$hotels_by_country = array();
					
					while ($query->have_posts()) : $query->the_post();

						$hotel_code = get_field('hotel_code');
						
						$user_ids = get_field('user');

						if (in_array('administrator', (array) $user->roles) || in_array('headofoperations', (array) $user->roles) || is_array($user_ids) && in_array(get_current_user_id(), $user_ids)) {
							$country = get_field('country');

							$hotels_by_country[$country][] = 
							'<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">
								<figure><span class="material-symbols-outlined">room_service</span></figure>'
								. get_field('hotel_code') .
							'</a>';
						}
					endwhile;

					foreach ($hotels_by_country as $country => $hotels) {
						echo '<div class="aside__country"><div class="card__header"><span class="material-symbols-outlined">add</span><h4>' . $country . '</h4></div><div class="card__body"  style="display: none;">';
						foreach ($hotels as $hotel) {
							echo $hotel;
						}
						echo '</div></div>';
					}

					wp_reset_postdata();
					echo '</nav></div>';
				endif;
			}
		}
		?>
		<a href="/tickets" class="aside__tickets"><?php if(!is_single()) : echo 'Support Center'; else: echo 'Support Tickets'; endif; ?></a>
	</div>
</aside>