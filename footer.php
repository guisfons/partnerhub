<?php wp_footer(); ?>
</main>
<footer class="footer">
    <div class="loading-screen">
        <div class="loading-spinner"></div>
    </div>
</footer>

<?php if(is_singular('hotels')) : get_template_part('template-parts/canvas/canvas'); endif; ?>

</body>

</html>