<section class="latest-updates">
    <h2>WHAT'S GOING ON AT REGIÔTELS </h2>

    <div class="card">
        <h4>Current Offer</h4>
        <?php $current_offer = get_field('current_offer', 'option'); ?>
        <figure>
            <a href="<?= $current_offer['url']; ?>" target="_blank" title="Current Offer"><img src="<?= $current_offer['image']; ?>" alt="Current Offer"></a>
        </figure>
    </div>
    <div class="card">
        <h4>Social Media News</h4>
        <?php $social_media_news = get_field('social_media_news', 'option'); ?>
        <figure>
            <a href="<?= $social_media_news['url']; ?>" target="_blank" title="Social Media News"><img src="<?= $social_media_news['image']; ?>" alt="Social Media News"></a>
        </figure>
    </div>
    <div class="card">
        <h4>Latest Blog Post</h4>
        <?php $latest_blog_post = get_field('latest_blog_post', 'option'); ?>
        <figure>
            <a href="<?= $latest_blog_post['url']; ?>" target="_blank" title="Latest Blog Post"><img src="<?= $latest_blog_post['image']; ?>" alt="Latest Blog Post"></a>
        </figure>
    </div>
    <!-- <div class="card">
        <h4>Upcoming Events</h4>
    </div> -->
</section>