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
	<link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/lib/slick.css">

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

<body <?php body_class($post->post_name ?? ''); ?> data-role="<?php echo $user_role; ?>">

	<?php
	if (is_user_logged_in() && is_front_page() || is_page('messages') || is_singular('hotels') || is_page('notifications')) {
		get_sidebar('sidebar');
	?>
		<header class="header-user">
			<?php if(is_front_page()): ?>
			<span class="title"><span>Hello, <?php echo $user->user_firstname; ?></span><br /><br />
				<h1><?= (!current_user_can('contributor') ? 'ADMINISTRATIVE PARTNERHUB HOME' : 'Hotel Administrative Panel'); ?></h1>
			</span>
			<?php endif; ?>

			<a href="/notifications" class="header-user__notification">
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
			<a href="/" class="header-user__profile">
				<figure>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/user.webp" alt="<?= $user->user_login; ?>">
				</figure>
				<?= $user->user_login; ?>
			</a>

			<a href="<?php echo wp_logout_url(get_home_url()); ?>">
				<figure class="header-user__logout"><span class="material-symbols-outlined">logout</span></figure> LOGOUT
			</a>
		</header>

	<?php } ?>
	<main>