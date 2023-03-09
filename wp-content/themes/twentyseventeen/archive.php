<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<!-- /***********************init post */ -->
			<!-- Page header with logo and tagline-->
			<?php if (have_posts()) : ?>
				<header class="py-5 bg-light border-bottom mb-4">
					<div class="container">
						<div class="text-center my-5">
							<?php
							the_archive_title('<h1 class="page-title">', '</h1>');
							the_archive_description('<div class="taxonomy-description">', '</div>');
							?>
							</p>
						</div>
					</div>
				</header>
			<?php endif; ?>
			<!-- Page content-->
			<div class="container">
				<div class="row">
					<!-- Blog entries-->
					<div class="col-lg-8">
						<?php
						if (have_posts()) :
						?>
						<?php
							// Start the Loop.
							while (have_posts()) :
								the_post();

								/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that
				 * will be used instead.
				 */
								get_template_part('template-parts/post/content', get_post_format());

							endwhile;

							the_posts_pagination(
								array(
									'prev_text'          => twentyseventeen_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'twentyseventeen') . '</span>',
									'next_text'          => '<span class="screen-reader-text">' . __('Next page', 'twentyseventeen') . '</span>' . twentyseventeen_get_svg(array('icon' => 'arrow-right')),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyseventeen') . ' </span>',
								)
							);

						else :

							get_template_part('template-parts/post/content', 'none');

						endif;
						?>
					</div>
					<!-- Side widgets-->
					<div class="col-lg-4">
						<!-- Search widget-->
						<div class="card mb-4">
							<div class="card-header primary-background text-white">Buscar</div>
							<div class="card-body">
								<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
									<div class="input-group">
										<input type="search" class="form-control search-field" placeholder="<?php echo esc_attr_x('Buscar …', 'placeholder') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>" />
										<input type="submit" class="btn btn-primary btn-sm border-0 rounded-0" value="<?php echo esc_attr_x('Search', 'submit button') ?>" />
									</div>
								</form>
							</div>
						</div>
						<!-- Categories widget-->
						<div class="card mb-4">
							<div class="card-header primary-background text-white">Publicaciones recientes</div>
							<div class="card-body">
								<div class="row">
									<?php wcr_related_posts(); ?>
								</div>
							</div>
						</div>
						<!-- Side widget-->
						<div class="card mb-4">
							<div class="card-header primary-background text-white">Categorías</div>
							<div class="card-body"><?php
													$args = array(
														'title_li' => '',
														'orderby' => 'count',
														'order' => 'DESC',
														'number' => 5,
														'show_count' => 1,
														'pad_counts' => 0
													);
													wp_list_categories($args);
													?></div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>
<!-- < ?php get_sidebar(); ?> -->

<?php
get_footer();
