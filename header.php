<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<?php
	wp_head();
	global $current_user;
	wp_get_current_user();

	?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- Assets -->

	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<!-- Gerador de Favicon -->
	<!-- https://realfavicongenerator.net/ -->

	<title><?php echo get_bloginfo('name') . ' &#8212; ' . (is_user_logged_in() ? (is_front_page() ? 'Home' : wp_title('', false)) : 'Login'); ?></title>
</head>
<?php
$user = new WP_User(get_current_user_id());
$user_role = '';
if (!empty($user->roles) && is_array($user->roles)) {
	foreach ($user->roles as $role) {
		$user_role = $role;
	}
}

$user = wp_get_current_user();

?>

<body <?php body_class($post->post_name ?? ''); ?> data-role="<?php echo $user_role; ?>" <?php if (is_singular('hotels')) { echo 'data-hotel-code="' . get_field('hotel_code') . '"'; } ?>>
	<?php
	if (
		is_user_logged_in() && is_front_page() || 
		in_array(true, [
			is_page('messages'),
			is_singular('hotels'),
			is_page('notifications'),
			is_page('profile')
		])
	) {
		get_sidebar('sidebar');
	?>
		<header class="header-user">
			<?php
			$posts = get_posts(array(
				'posts_per_page' => -1,
				'post_type' => 'hotels',
				'meta_query' => array(
					array(
						'key' => 'user',
						'value' => '"' . get_current_user_id() . '"',
						'compare' => 'LIKE',
					),
				),
			));
	
			if(in_array('contributor', (array)$user_role) && !empty($posts) && count($posts) > 1) {
			?>
			<a href="<?= get_home_url(); ?>/hotel-select/" class="header-user__profile">
				<figure>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/switch.webp" alt="Switch hotel account">
				</figure>
				Switch
			</a>
			<?php } ?>

			<a href="<?= get_home_url(); ?>/notifications" class="header-user__notification">
				<figure>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/bell.webp" alt="Messages">
					<span></span>
				</figure>
				Notifications
			</a>

			<!-- <a href="<?= do_shortcode('[better_messages_my_messages_url]'); ?>">
				<figure>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/messages.webp" alt="Messages">
					<span><?= do_shortcode('[better_messages_unread_counter hide_when_no_messages="1" preserve_space="1"]'); ?></span>
				</figure>
				Messages
			</a> -->
			
			<a href="/profile" class="header-user__profile">
				<figure>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/user.webp" alt="<?= $user->user_login; ?>">
				</figure>
				<?= $user->user_login; ?>
			</a>

			<a href="<?php echo wp_logout_url( home_url() ); ?>">
				<figure class="header-user__logout"><span class="material-symbols-outlined">logout</span></figure> LOGOUT
			</a>
		</header>

	<?php } ?>
	<main>