<?php $user = wp_get_current_user(); ?>
<aside class="aside aside--active">
	<button class="aside__button"><span class="material-symbols-outlined"></span></button>
	<figure class="aside__logo"><img src="<?= get_template_directory_uri(); ?>/assets/img/logo.webp" alt="Logo">PartnerHub</figure>
	<div class="aside__container" data-simplebar>
		<?php
		if (!is_singular('hotels')) {
			if (!is_front_page() || !is_home()) {
				if (!in_array('contributor', (array) $user->roles)) {
					echo '<a href="' . get_home_url() . '" title="Home" class="aside__item aside__item--home">Home</a>';
				} else {
					echo '<a href="' . get_home_url() . '" title="Home" class="aside__item aside__item--home">Hotel Dashboard</a>';
				}
			}
		}

		if (is_singular('hotels')) {
			if (!in_array('contributor', (array) $user->roles)) {
				echo '<a href="' . get_home_url() . '" title="Home" class="aside__item aside__item--home">PartnerHub Home</a>';
			} else {
				echo '<button data-menu="home" class="aside__item aside__item--home">Home</button>';
			}

			$hotel_code = get_field('hotel_code');

			if($hotel_code == 'EXA') {
				echo
				'<div class="aside__menu">
					<button class="aside__item">Dashboards<span></span></button>
					<div class="aside__item-submenu" style="display: none;">
						<span class="aside__item-head"><span class="material-symbols-outlined">add</span>
							<h4>Website Dashboards</h4>
						</span>
						<div class="aside__item-submenu-sub" style="display: none;">
							<span data-menu="web-report">
								<h4>Channel Report</h4>
							</span>
							<span data-menu="geo-traffic">
								<h4>Geographic Report</h4>
							</span>
							<span data-menu="page-traffic">
								<h4>Page Traffic Report</h4>
							</span>
							<span data-menu="ibe-sales">
								<h4>IBE Sales Report</h4>
							</span>
						</div>

						<span class="aside__item-head"><span class="material-symbols-outlined">add</span>
							<h4>Revenue Dashboards</h4>
						</span>
						<div class="aside__item-submenu-sub" style="display: none;">
							<span data-menu="monthly-dashboard">
								<h4>Monthly Dashboard</h4>
							</span>
							<span data-menu="year-to-date-dashboard">
								<h4>Year to Date Dashboard</h4>
							</span>
							<span data-menu="monthly-channels-dashboard">
								<h4>Monthly Channels Dashboard</h4>
							</span>
							<span data-menu="year-to-date-channels-dashboard">
								<h4>Year to Date Channels Dashboard</h4>
							</span>
							<span data-menu="full-year">
								<h4>Full Year</h4>
							</span>
						</div>
						<span class="aside__item-head"><span class="material-symbols-outlined">add</span>
							<h4>Ad Dashboards</h4>
						</span>
						<div class="aside__item-submenu-sub" style="display: none;">
							<span data-menu="meta-ads">
								<h4>Meta Ads</h4>
							</span>
							<span data-menu="google-ads">
								<h4>Google Ads</h4>
							</span>
						</div>
					</div>
				</div>';
			}
		?>
			<div class="aside__menu">
				<button class="aside__item">General Info <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="a-la-carte-services">
						<h4>A La Carte Services</h4>
					</span>
					<span data-menu="contract">
						<h4>Contract</h4>
					</span>
					<span data-menu="offers">
						<h4>Offers</h4>
					</span>
					<span data-menu="invoices">
						<h4>Invoices</h4>
					</span>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">Property Info <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span data-menu="onboarding">
						<h4>Onboarding</h4>
					</span>
					<span data-menu="corporate-identity">
						<h4>Corporate Identity</h4>
					</span>
					<span data-menu="photos">
						<h4>Hotel Photos</h4>
					</span>
					<span data-menu="rooms">
						<h4>Room Photos</h4>
					</span>
					<span data-menu="menus">
						<h4>Menus</h4>
					</span>
					<span data-menu="texts">
						<h4>Texts</h4>
					</span>
					<span data-menu="facilities-services">
						<h4>Facilities & Services</h4>
					</span>
				</div>
			</div>
			<div class="aside__menu">
				<button class="aside__item">Deliverables <span></span></button>
				<div class="aside__item-submenu" style="display: none;">
					<span class="aside__item-head"><span class="material-symbols-outlined">add</span>
						<h4>Revenue & Distribution</h4>
					</span>
					<div class="aside__item-submenu-sub" style="display: none;">
						<span data-menu="pickup-report">
							<h4>Pickup Report</h4>
						</span>
						<span data-menu="monthly-dashboard-report">
							<h4>Monthly Dashboard Report</h4>
						</span>
						<span data-menu="pricing-structure">
							<h4>Pricing Structure</h4>
						</span>
						<span data-menu="calendars">
							<h4>Calendars</h4>
						</span>
					</div>
					<span class="aside__item-head"><span class="material-symbols-outlined">add</span>
						<h4>Digital Marketing</h4>
					</span>
					<div class="aside__item-submenu-sub" style="display: none;">
						<span data-menu="seo-review">
							<h4>SEO Review</h4>
						</span>
						<span data-menu="marketing-suggestions">
							<h4>Marketing Suggestions</h4>
						</span>
						<span data-menu="web-traffic-analytics-dashboard">
							<h4>Web Traffic Analytics Dashboard</h4>
						</span>
						<span data-menu="social-media-posts">
							<h4>Social Media Posts</h4>
						</span>
						<span data-menu="webaudit-report">
							<h4>Webaudit Report</h4>
						</span>
					</div>
					<span data-menu="online-sales">
						<h4>Online Sales</h4>
					</span>
				</div>
			</div>
			<?php
			$allowed_roles = array('administrator', 'editor', 'contributor', 'revenuemanager');
			$user_roles = (array) $user->roles;
			if (array_intersect($allowed_roles, $user_roles)) :
			// echo
			// '<div class="aside__menu">
			// 	<button class="aside__item">Revenue Automation <span></span></button>
			// 	<div class="aside__item-submenu" style="display: none;">
			// 		<span data-menu="pricing-sheet"><h4>Pricing Sheet</h4></span>
			// 		<span data-menu="room-pricing"><h4>Room Pricing</h4></span>
			// 		<span data-menu="occupancy-rate"><h4>Occupancy Rate</h4></span>
			// 	</div>
			// </div>';	
			endif;
			// if (in_array('contributor', (array) $user_roles)) { ?>
				<div class="aside__menu">
					<button class="aside__item">Support Center <span></span></button>
					<div class="aside__item-submenu" style="display: none;">
						<span data-menu="request-new-ticket">
							<h4>Request New Ticket</h4>
						</span>
						<span data-menu="track-open-tickets">
							<h4>Track Open Tickets</h4>
						</span>
						<span data-menu="closed-tickets">
							<h4>Closed Tickets</h4>
						</span>
					</div>
				</div>
		<?php
			// }
		} else {
			$allowed_roles = array('administrator', 'editor', 'headofoperations', 'contributor', 'revenuemanager');
			$user_roles = (array) $user->roles;

			if (is_front_page() && array_intersect($allowed_roles, $user_roles)) {
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
	</div>
</aside>