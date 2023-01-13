<?php get_header();?>
            <div id="cuerpo">
                <div id="contenidoCuerpo">
                    <h1 class="titleArticulos">
                        <div class="paginationPrev">
                        <?php previous_posts_link("<< Anteriores");?>
                        </div>
                        <div class="paginationNext">
                        <?php next_posts_link("Siguientes >>");?>
                        </div>
                        <?php single_cat_title("",true); ?>
                    </h1>
                    <?php if(have_posts()): while(have_posts()) : the_post();?>
                            <div class="bloqueArticulo">
                                <div class="imgListArticles">
                                    <a href="<?php bloqueArticulo; ?>"><?php if(has_post_thumbnail()){the_post_thumbnail('slider_small_thumbs');}?></a>
                                </div>
                                <h3><?php echo $t= str_replace("Private:","", the_title("", "", false));?></h3>
                                <div class="excerpt"><?php the_excerpt();?></div>
                                <a href="<?php the_permalink(); ?>" class="leerMasArticleList">Leer más</a>
                            </div>
                    <?php endwhile; 
                    else:?>
                    <div class="home_txt">
                        <h2>No hay artículos</h2>
                        <p>No hay artículos</p>
                    </div>
                    <?php endif;?>
<?php get_footer();?> 
