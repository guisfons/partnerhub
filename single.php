<?php
/**
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package UAU
 * @since 1.0.0
 */
if(is_user_logged_in()) {
	$user = wp_get_current_user();
    get_header();
    if(is_singular('hotels')) {
        echo '<nav class="breadcrumb"><a href="'.get_home_url().'" title="Home">Home</a><span>'.get_field('country').'</span><span data-post-name="'.get_post_field( 'post_name', get_post() ).'">'.get_the_title().'</span></nav>';
        $roles = (array) $user->roles;
        $required_roles = ['administrator', 'headofoperations'];
        $user_id = get_current_user_id();
        $allowed_users = get_field('user');
        if(array_intersect($roles, $required_roles) || in_array($user_id, $allowed_users)) {
            loadModulesCssForTemplate('administration.min.css');
            get_template_part('template-parts/hotel-dashboard');
    
            loadModulesCssForTemplate('general-property.min.css');
            get_template_part('template-parts/general-info');

            get_template_part('template-parts/property-info');
    
            get_template_part('template-parts/regiotels-deliverables');

            get_template_part('template-parts/pricing-sheet');
            get_template_part('template-parts/revenue-automation');
            
            echo '<section data-content="home" class="content">';
            get_template_part('template-parts/home');
            echo '</section>';

            // if(in_array('contributor', $roles)) {
                get_template_part('template-parts/support-ticket');
            // }
        } else {
            echo '<style>.header > span {display: none;}</style><h2 class="wrapper error" style="margin-top: 5vh;">You have no permission to see this page.</h2>';
        }
    } else {
        loadModulesCssForTemplate('news.min.css');
        while ( have_posts() ) : the_post();
            echo '<section class="news"><arcticle class="wrapper news__container"><h1>'.get_the_title().'</h1>'.get_the_content().'</arcticle></section>';
        endwhile;
        wp_reset_postdata();
    }
    get_footer();
} else {
    wp_redirect(home_url());
    exit();
}