<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>

<?php
while (have_posts()) :
	the_post();
?>
	<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<!-- /***********************init post */ -->
				<!-- Page header with logo and tagline-->
				<header class="py-5 bg-light border-bottom mb-4">
					<div class="container">
						<div class="text-center my-5">
							<h2 class="fw-bolder"><?= mb_strtoupper(esc_html(get_the_title())); ?></h2>
						</div>
					</div>
				</header>
				<!-- Page content-->
				<div class="container">
					<div class="row">
						<!-- Blog entries-->
						<div class="col-lg-8">
							<!-- Featured blog post-->
							<?php
							if (getDetailImg()) { // existe imagen destacada							
							?>
								<div class="card mb-4">
									<?php if (getDetailImg()['detail']['url']) { ?>
										<a href="#!"><img class="card-img-top" src="<?= getDetailImg()['detail']['url'] ?>" alt="<?= getDetailImg()['detail']['post_content']; ?>" /></a>
									<?php } ?>
									<div class="card-body">
										<figcaption>
											<div class="small text-muted twentyseventeen-font-size-theme-15-5"><?= getDetailImg()['detail']['post_date']; ?> <?= getDetailImg()['detail']['post_excerpt']; ?></div>
										</figcaption>
										<?php if (getDetailImg()['detail']['post_content']) { ?>
											<h2 class="card-title"><?= getDetailImg()['detail']['post_content']; ?></h2>
										<?php } ?>
										<section>
											<?php
											global $more;

											if (is_sticky()) {
												// Set (inside the loop) to display all content, including text below more.
												$more = 1;

												the_content();
											} else {
												$more = 0;

												the_content(__('Read the rest of this entry »', 'textdomain'));
											}
											?>
										</section>
										<!-- <a class="btn btn-primary" href="#!">Read more →</a> -->
									</div>
								</div>
							<?php } ?>
							<!-- Pagination-->
							<nav aria-label="Pagination">
								<hr class="my-0" />
								<?php
								$paginate = the_post_navigation(
									array(
										'prev_text' => __('Anterior', 'twentyseventeen'),
										'next_text' => __('Siguiente', 'twentyseventeen')
									)
								);
								?>
							</nav>
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
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .wrap -->
	<!-- Main Body -->
	<section>
		<div class="container">
			<div class="row">
				<!-- <div class="col-sm-5 col-md-6 col-12 pb-4">
					<h3>Comentarios</h3>
					< ?php wp_list_comments(); ?>
				</div> -->
				<div class="col-lg-10 col-md-10 col-sm-10 offset-md-1 offset-sm-1 col-12 mt-4">
					<div class="list-unlysted">
						<?php						
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /**********************************end post */ -->
<?php
endwhile; // End the loop.
?>
<?php //get_sidebar(); 
?>
<?php
get_footer();
