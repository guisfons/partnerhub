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
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- Assets -->
	<link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/lib/slick.css">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <!-- Gerador de Favicon -->
    <!-- https://realfavicongenerator.net/ -->

	<title><?php echo get_bloginfo('name') . ' &#8212; ' . (is_user_logged_in() ? (is_front_page() ? 'Home' : wp_title('', false)) : 'Login'); ?></title>
</head>
<?php
$user = new WP_User( get_current_user_id() );
$user_role = '';
if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
    foreach ( $user->roles as $role ) {
		$user_role = $role;
	}
}
?>
<body <?php body_class($post->post_name ?? ''); ?> data-role="<?php echo $user_role; ?>">

<?php
if(is_user_logged_in()) {
	if(is_single()) {
		echo '<header class="header"><a href="'.get_home_url().'" class="header__home"><span class="material-symbols-outlined">home</span></a>';
			if(is_singular('hotels')) {
			echo
			'<span data-menu="administration" class="header__item">Administration</span>
			<span data-menu="general-property" class="header__item">General Property Info</span>
			<span>
				<span data-menu="revenue-distribution" class="header__item">RegiÔtels Deliverables</span>
	
				<div class="header__submenu">
					<span data-menu="revenue-distribution" class="header__item">Revenue & Distribution</span>
					<span data-menu="digital-marketing" class="header__item">Digital Marketing</span>
					<span data-menu="online-sales" class="header__item">Online Sales</span>
				</div>
			</span>
			<span>
				<span data-menu="siteminder" class="header__item">Pricing Sheet</span>
				<div class="header__submenu">
					<span data-menu="siteminder" class="header__item">Siteminder</span>
					<span data-menu="dirs21" class="header__item">Dirs21</span>
					<span data-menu="cubilis" class="header__item">Cubilis</span>
					<span data-menu="hoteliersguru" class="header__item">HoteliersGuru</span>
				</div>
			</span>';
		}
		echo '<a href="'.esc_url(wp_logout_url()).'" class="header__logout"><span class="material-symbols-outlined">logout</span></a></header>';
	}

	if (is_front_page() || is_page('messages')) { get_sidebar('sidebar'); }
}
?>
	<main>