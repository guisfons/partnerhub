<aside class="aside aside--active">
	<button>
		<span class="material-symbols-outlined"></span>
	</button>
	<?php
	if (is_singular('hotels')) {
		echo
		'<nav class="aside__menu"><span data-menu="administration" class="aside__item"><span class="material-symbols-outlined">add</span><h4>Administration</h4></span>
		<span data-menu="general-property" class="aside__item"><span class="material-symbols-outlined">add</span><h4>General Property Info</h4></span>
		<span>
			<span class="aside__item"><span class="material-symbols-outlined">add</span><h4>RegiÔtels Deliverables</h4></span>

			<div class="aside__submenu" style="display: none;">
				<span data-menu="revenue-distribution" class="aside__item"><h4>Revenue & Distribution</h4></span>
				<span data-menu="digital-marketing" class="aside__item"><h4>Digital Marketing</h4></span>
				<span data-menu="online-sales" class="aside__item"><h4>Online Sales</h4></span>
			</div>
		</span>
		<span>
			<span class="aside__item"><span class="material-symbols-outlined">add</span><h4>Pricing Sheet</h4></span>
			<div class="aside__submenu" style="display: none;">
				<span data-menu="siteminder" class="aside__item"><h4>Siteminder</h4></span>
				<span data-menu="dirs21" class="aside__item"><h4>Dirs21</h4></span>
				<span data-menu="cubilis" class="aside__item"><h4>Cubilis</h4></span>
				<span data-menu="hoteliersguru" class="aside__item"><h4>HoteliersGuru</h4></span>
			</div>
		</span></nav>';
	} else {
	?>

	<figure class="aside__logo"><img src="<?= get_template_directory_uri(); ?>/assets/img/logo.webp" alt="Logo">PartnerHub</figure>

	<?php
		$user = wp_get_current_user();
		if (in_array('administrator', (array) $user->roles) || in_array('editor', (array) $user->roles) || in_array('contributor', (array) $user->roles) || in_array('revenuemanager', (array) $user->roles)) {
			$args = array(
				'post_type'      => 'hotels',
				'posts_per_page' => -1,
				'meta_key'       => 'country',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) :
				echo '<div class="aside__hotels"><h2>Hotels <span></span></h2><nav>';

				$hotels_by_country = array();

				while ($query->have_posts()) : $query->the_post();

					if (in_array('administrator', (array) $user->roles) || in_array(get_current_user_id(), get_field('user'))) {
						$country = get_field('country');

						$hotels_by_country[$country][] = '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '"><figure>' . (!empty(get_field('corporate_identity_logos')[0]['url']) ? '<img src="' . get_field('corporate_identity_logos')[0]['url'] . '" alt="' . get_the_title() . '">' : '<span class="material-symbols-outlined">room_service</span>') . '</figure>' . get_the_title() . '</a>';
					} else {
						echo '<h2 class="error">No Hotels found</h2>';
					}
				endwhile;


				foreach ($hotels_by_country as $country => $hotels) {
					echo '<div class="aside__country"><div class="card__header"><span class="material-symbols-outlined">add</span><h4>' . $country . '</h4></div><div class="card__body" style="display: none;">';
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
</aside>