<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                <h3>
                    <?php bloginfo('name'); ?>
                </h3>
                <p>Fanartikel zu unschlagbaren Preisen</p>
            </div>

            <?php if (is_active_sidebar('footer-1')): ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>

            <nav class="footer-navigation">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'menu_id' => 'footer-menu',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                    'depth' => 1,
                ]);
                    ?>
            </nav>
        </div>

        <div class="footer-bottom">
            <p>&copy;
                <?php echo date('Y'); ?>
                <?php bloginfo('name'); ?>. Alle Rechte vorbehalten.
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>