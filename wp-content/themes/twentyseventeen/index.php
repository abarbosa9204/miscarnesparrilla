<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>

<!-- index original -->
<!-- Banner Section End -->

<!-- Services Section Start -->
<?php
if (is_user_logged_in()) {
?>
<div class="container">
	<div class="sec-title2 text-center mb-50">
		<h2 class="title testi-title">
			Calidad
		</h2>
		<p class="desc desc3">
			<!--Perspiciatis unde omnis iste natus error sit voluptatem accus antium doloremque laudantium, totam rem aperiam,
			eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.-->
		</p>
	</div>
	<div class="row row align-items-center">
	<div class="col-lg-1">
	</div>
		<div class="col-lg-2">
			<div class="btn-part">
				<a class="readon more-calidad"  style="height: 85px;padding-top: 16%;" data-toggle="modal" data-target="#modal_detalle" onclick="detalle(23)">Manuales<br></a>
			</div>

		</div>
		<div class="col-lg-2">
			<div class="btn-part">
				<a class="readon more-calidad" data-toggle="modal" data-target="#modal_detalle" onclick="detalle(23)">Procedimientos e Instructivos</a>
			</div>

		</div>
		<div class="col-lg-2">
			<div class="btn-part">
				<a class="readon more-calidad" data-toggle="modal" data-target="#modal_detalle" onclick="detalle(23)">Fichas Técnicas</a>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="btn-part">
				<a class="readon more-calidad" data-toggle="modal" data-target="#modal_detalle" onclick="detalle(23)">Capacitaciones y Evaluaciones</a>
			</div>

		</div>
		<div class="col-lg-2">
			<div class="btn-part">
				<a class="readon more-calidad" data-toggle="modal" data-target="#modal_detalle" onclick="detalle(23)">Documentación legal</a>
			</div>

		</div>
		<div class="col-lg-1">
	</div>
	</div>
</div>
<div class="rs-services style8 pt-120 pb-120 md-pt-80 md-pb-80">
	<div class="container">
		<div class="row align-items-center">
			<?php
			$args = [
				'numberposts' => 3,
				'offset' => 0,
				'category' => 0,
				'cat' => "-10,-4,-14",
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'post',
				'post_status' => 'publish',
				'suppress_filters' => true,
			];

			$recent_posts = wp_get_recent_posts($args);
			$colors = [
				'',
				'gray-light-bg',
				'pink-bg'
			];
			if (count($recent_posts) > 0) {
				$lineColor = 0;
				foreach ($recent_posts as $key => $recent) : $permalink = get_permalink($recent["ID"]);
					$thumbnail =  get_the_post_thumbnail($recent["ID"], 'slider_small_thumbs');
			?>
					<div class="col-lg-4 col-md-6 md-mb-30">
						<div class="services-item <?= $colors[($lineColor > count($colors) - 1 ? $lineColor = 0 : $lineColor)] ?>">
							<div class="text-right">
								<h6 class="p-0 m-0">Publicado el <?= date("Y-m-d H:i:s a", strtotime($recent['post_modified'])); ?></h6>
							</div>
							<div class="services-img">
								<?php
								$init = strpos($recent['post_content'], '<figure');
								if ($init > 0) {
									$end = strpos($recent['post_content'], '</figure>');
									echo explode('</figure>', substr($recent['post_content'], $init, $end))[0];
								} else {
								?>
									<figure class="wp-block-image size-full is-resized is-style-default">
										<img src="<?php bloginfo('template_directory') ?>/assets/images/sin-imagen.jpg" alt="Sin imagen" class="wp-image-25" width="838" height="513">
									</figure>
								<?php
								}
								?>
							</div><br>
							<div class="services-content">
								<div class="services-title">
									<h3 class="title" data-toggle="tooltip" data-placement="top" title="<?php echo $recent["post_title"]; ?>"> <?php echo $recent["post_title"]; ?></h3>
								</div>
								<div>
									<p class="services-txt" data-toggle="tooltip" data-placement="top" title="<?php echo $recent["post_excerpt"]; ?>"> <?php echo $recent["post_excerpt"]; ?>
								</div>
								<div>
									<a href="<?php echo $permalink; ?>" class="read-more-post">Leer más...</a>
								</div>
							</div>
						</div>
					</div>

			<?php
					$lineColor++;
				endforeach;
			} ?>
		</div>
	</div>
</div>
<?php
}
?>
<!-- Services Section End -->
<!-- <.?php echo esc_html_x('Tags:', 'Label for a list of post tags', 'twentytwentyfour'); ?> -->

<?php
get_footer();
