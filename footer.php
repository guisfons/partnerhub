<?php wp_footer(); ?>
    </main>
    <footer class="footer">
        <div class="loading-screen">
            <div class="loading-spinner"></div>
        </div>
        <?php if(is_user_logged_in()) {
            
        } ?>
    </footer>
    <script src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/lib/jquery-3.7.1.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/lib/slick.min.js'); ?>"></script>
    <script src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/js/main.js'); ?>"></script>
    <script src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/js/acf-functions.js'); ?>"></script>
</body>
</html>