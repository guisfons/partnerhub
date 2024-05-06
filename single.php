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
        echo '<nav class="breadcrumb"><a href="'.get_home_url().'" title="Home">Home</a><span>'.get_field('country').'</span></nav>';
        while ( have_posts() ) : the_post();
            if(in_array( 'administrator', (array) $user->roles ) || in_array(get_current_user_id(), get_field('user'))) {
                loadModulesCssForTemplate('administration.min.css');
                get_template_part('template-parts/administration');
        
                loadModulesCssForTemplate('general-property.min.css');
                get_template_part('template-parts/general-property');
        
                get_template_part('template-parts/regiotels-deliverables');

                get_template_part('template-parts/pricing-sheet');
            } else {
                echo '<style>.header > span {display: none;}</style><h2 class="wrapper error" style="margin-top: 5vh;">You have no permission to see this page.</h2>';
            }
        endwhile;
        wp_reset_postdata();
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