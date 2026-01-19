<?php
/**
 * The main template file
 *
 * @package Fanartikel
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p><?php _e('Keine Inhalte gefunden.', 'fanartikel'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
