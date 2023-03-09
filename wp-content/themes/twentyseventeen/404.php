<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
			<!-- Page content-->
			<div class="container">
				<div class="row">
					<!-- Blog entries-->
					<div class="col-lg-12">
						<section class="error-404 not-found">
							<header class="page-header">
								<h1 class="page-title"><?php _e('Oops! Esa página no se encuentra.', 'twentyseventeen'); ?></h1>
							</header><!-- .page-header -->
							<div class="page-content">
								<p><?php _e('Parece que no se ha encontrado nada en este lugar. ¿Tal vez intentar una búsqueda?', 'twentyseventeen'); ?></p>

								<?php get_search_form(); ?>
							</div>
						</section><!-- .error-404 -->
					</div>
				</div>
			</div><!-- .page-content -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
