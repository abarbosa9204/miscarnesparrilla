<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
			<header class="py-5 bg-light border-bottom mb-4">
				<div class="container">
					<div class="text-center my-5">
						<?php if (have_posts()) : ?>
							<h2 class="fw-bolder"><?php
													/* translators: Search query. */
													printf(__('Resultados de la búsqueda de: %s', 'twentyseventeen'), '<span>' . get_search_query() . '</span>');
													?></h2>
						<?php else : ?>
							<h2 class="fw-bolder"><?php _e('Nothing Found', 'twentyseventeen'); ?></h2>
						<?php endif; ?>

					</div>
				</div>
			</header>
			<!-- Page content-->
			<div class="container">
				<div class="row">
					<!-- Blog entries-->
					<div class="col-lg-8">
						<?php
						if (have_posts()) :
							// Start the Loop.
							while (have_posts()) :
								the_post();

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part('template-parts/post/content', 'excerpt');

							endwhile; // End the loop.

							the_posts_pagination(
								array(
									'prev_text'          => twentyseventeen_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'twentyseventeen') . '</span>',
									'next_text'          => '<span class="screen-reader-text">' . __('Next page', 'twentyseventeen') . '</span>' . twentyseventeen_get_svg(array('icon' => 'arrow-right')),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyseventeen') . ' </span>',
								)
							);

						else :
						?>

							<p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen'); ?></p>
						<?php
							get_search_form();

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
<?php
get_footer();
