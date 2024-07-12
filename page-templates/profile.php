<?php

/**
 * Template Name: Profile Page
 * Template Post Type: page
 *
 * @package UAU
 * @since 1.0.0
 */

get_header();
loadModulesCssForTemplate('profile.min.css');

$user_id = get_current_user_id();
$user = wp_get_current_user();
?>

<section class="content content--active">
    <h1>Profile</h1>

    <div class="card card--profile">
        <div class="card--profile__header">
            <figure>
                <img src="<?= esc_url(get_avatar_url($user_id)); ?>" alt="<?= $user->first_name; ?>">
                <span class="material-symbols-outlined">edit</span>
            </figure>
            <span><span></span> Active</span>
            <a href="mailto:<?= $user->user_email; ?>" target="_blank"><?= $user->user_email; ?></a>
        </div>
        <div class="card--profile__body">
            <input type="hidden" name="userId" value="<?= $user_id; ?>">
            <input type="text" name="<?= $user->user_login; ?>" id="<?= $user->user_login; ?>" placeholder="<?= $user->user_login; ?>" value="<?= $user->user_login; ?>" disabled>
            <input type="text" name="<?= $user->roles[0]; ?>" id="<?= $user->roles[0]; ?>" placeholder="<?= $user->roles[0]; ?>" value="<?= ucwords($user->roles[0]); ?>" disabled>

            <div class="card--profile__body-login">
                <h3>Login email and Password</h3>
                
                <label for="email">
                    <input type="email" name="email" id="email" placeholder="<?= $user->user_email; ?>" value="<?= $user->user_email; ?>" disabled>
                    <button class="card--profile__edit">Edit</button>
                </label>

                <label for="password">
                    <input type="password" name="password" id="password" placeholder="<?= $user->user_pass; ?>" value="<?= $user->user_pass; ?>" disabled>
                    <button class="card--profile__edit">Edit</button>
                </label>
            </div>
        </div>
    </div>

</section>

<?php get_footer();
