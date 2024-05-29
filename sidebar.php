<?php $user = wp_get_current_user(); ?>
<aside class="aside aside--active">
	<button class="aside__button"><span class="material-symbols-outlined"></span></button>
	<figure class="aside__logo"><img src="<?= get_template_directory_uri(); ?>/assets/img/logo.webp" alt="Logo">PartnerHub</figure>
	<div class="aside__container">
		<?php
		if(is_page('notifications')) {
			echo '<a href="'.get_home_url().'" title="Home" class="aside__item">Home</a>';
		}

		if (is_singular('hotels') || current_user_can('contributor')) {
			if(!current_user_can('contributor')) {
				echo '<button class="aside__item"><a href="'.get_home_url().'" title="Home">PartnerHub Home</a></button>';
			} else {
				echo '<button data-menu="home" class="aside__item">Home</button>';
			}

			// Get the current hotel code
			$hotel_code = get_field('hotel_code');

			?>
			<div class="aside__menu">
				<button class="aside__item">Dashboards<span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span class="aside__item-head"><span class="material-symbols-outlined">add</span><h4>Website Dashboards</h4></span>
					<div class="aside__item-submenu-sub" style="display: none;">
					<span data-menu="web-report"><h4>Channel Report</h4></span>
					<span data-menu="geo-traffic"><h4>Geographic Report</h4></span>
					<span data-menu="page-traffic"><h4>Page Traffic Report</h4></span>
					<span data-menu="ibe-sales"><h4>IBE Sales Report</h4></span>
					</div>

					<span class="aside__item-head"><span class="material-symbols-outlined">add</span><h4>Revenue Dashboards</h4></span>
					<div class="aside__item-submenu-sub" style="display: none;">
						<span data-menu="monthly-dashboard"><h4>Monthly Dashboard</h4></span>
						<span data-menu="year-to-date-dashboard"><h4>Year to Date Dashboard</h4></span>
						<span data-menu="monthly-channels-dashboard"><h4>Monthly Channels Dashboard</h4></span>
						<span data-menu="year-to-date-channels-dashboard"><h4>Year to Date Channels Dashboard</h4></span>
						<span data-menu="full-year"><h4>Full Year</h4></span>
					</div>
					<span class="aside__item-head"><span class="material-symbols-outlined">add</span><h4>Ad Dashboards</h4></span>
					<div class="aside__item-submenu-sub" style="display: none;">
						<span data-menu="meta-ads"><h4>Meta Ads</h4></span>
						<span data-menu="google-ads"><h4>Google Ads</h4></span>
					</div>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">General Info <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<?php if ($hotel_code != 'THANA') : ?>
					<span data-menu="a-la-carte-services"><h4>A La Carte Services</h4></span>
					<?php endif; ?>
					<span data-menu="contract"><h4>Contract</h4></span>
					<span data-menu="offers"><h4>Offers</h4></span>
					<span data-menu="invoices"><h4>Invoices</h4></span>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">Property Info <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="onboarding"><h4>Onboarding</h4></span>
					<span data-menu="corporate-identity"><h4>Corporate Identity</h4></span>
					<span data-menu="photos"><h4>Photos</h4></span>
					<?php if ($hotel_code != 'THANA') : ?>
					<span data-menu="menus"><h4>Menus</h4></span>
					<span data-menu="texts"><h4>Texts</h4></span>
					<span data-menu="facilities-services"><h4>Facilities & Services</h4></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">Deliverables <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span class="aside__item-head"><span class="material-symbols-outlined">add</span><h4>Revenue & Distribution</h4></span>
					<div class="aside__item-submenu-sub" style="display: none;">
						<?php if ($hotel_code != 'THANA') : ?>
						<span data-menu="pickup-report"><h4>Pickup Report</h4></span>
						<?php endif; ?>
						<span data-menu="monthly-dashboard-report"><h4>Monthly Dashboard Report</h4></span>
						<span data-menu="pricing-structure"><h4>Pricing Structure</h4></span>
						<span data-menu="calendars"><h4>Calendars</h4></span>
					</div>
					<span class="aside__item-head"><span class="material-symbols-outlined">add</span><h4>Digital Marketing</h4></span>
					<div class="aside__item-submenu-sub" style="display: none;">
						<?php if ($hotel_code != 'THANA') : ?>
						<span data-menu="seo-review"><h4>SEO Review</h4></span>
						<?php endif; ?>
						<span data-menu="marketing-suggestions"><h4>Marketing Suggestions</h4></span>
						<span data-menu="web-traffic-analytics-dashboard"><h4>Web Traffic Analytics Dashboard</h4></span>
						<span data-menu="social-media-posts"><h4>Social Media Posts</h4></span>
						<span data-menu="webaudit-report"><h4>Webaudit Report</h4></span>
					</div>
					<?php if ($hotel_code != 'THANA') : ?>
					<span data-menu="online-sales"><h4>Online Sales</h4></span>
					<?php endif; ?>
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
		<!-- <a href="/tickets" class="aside__tickets"><?php if(!is_single()) : echo 'Support Center'; else: echo 'Support Tickets'; endif; ?></a> -->
	</div>
</aside>