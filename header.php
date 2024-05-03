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
if(is_user_logged_in() && is_front_page() || is_page('messages') || is_singular('hotels')) {
	get_sidebar('sidebar');
}
?>
	<main>