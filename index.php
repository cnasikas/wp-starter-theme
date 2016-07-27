<?php get_header(); ?>
        <?php if ( have_posts() ) : ?>

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <?php endwhile; ?>


        <?php else : ?>

        <?php endif; ?>

<?php get_footer(); ?>