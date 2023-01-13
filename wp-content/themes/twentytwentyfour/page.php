<?php get_header(); ?>
<div id="cuerpo">
    <div id="contenidoCuerpo">
        <section id="columna1">
            <?php while (have_posts()) : the_post(); ?>
                <div class="">
                    <h2 class="titleArticulos"><?php echo $t = str_replace("Private: ", "", the_title("", "", false)); ?></h2>
                    <p><?php the_content(); ?></p>
                </div>
            <?php endwhile; ?>
        </section>
    </div>
</div>
<?php get_footer(); ?>