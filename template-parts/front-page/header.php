<?php $user = wp_get_current_user(); ?>
<section class="header-user">
    <span class="title"><span>Hello, <?php echo $user->user_firstname; ?></span><br/><br/><h1><?= (!current_user_can('contributor') ? 'ADMINISTRATIVE PARTNERHUB HOME' : 'Hotel Administrative Panel'); ?></h1></span>
    <a href="/">
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
    <a href="/">
        <figure>
            <img src="<?= get_template_directory_uri(); ?>/assets/img/user.webp" alt="<?= $user->user_login; ?>">
        </figure>
        <?= $user->user_login; ?>
    </a>
</section>