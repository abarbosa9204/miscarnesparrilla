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

			</h2>
			<p class="desc desc3">
				<!--Perspiciatis unde omnis iste natus error sit voluptatem accus antium doloremque laudantium, totam rem aperiam,
			eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.-->
			</p>
		</div>
		<!-- /****************************** */ -->

		<!-- Modal - Editar archivos -->
		<!-- Modal -->
		<div class="modal fade main-content" id="iframe-video-view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="iframe-video-viewLabel" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-dialog-centered modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetIframe('reset')">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="height: 72vh;">
						<div class="row video-iframe">
						</div>
					</div>
					<div class="modal-footer p-0">
						<button type="button" style="min-width: 90px;" class="btn btn-danger btn-sm twentyseventeen-font-size-theme-15-5" data-bs-dismiss="modal" onclick="resetIframe('reset')">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /******************************* */ -->
		<div class="row row align-items-center">
			<div class="row">
				<?php
				global $wpdb;
				$folders = $wpdb->get_results("SELECT * FROM  wpl_folder_files order by folder_row_id_order ASC");
				foreach ((array) $folders as $folder) {
				?>
					<!-- https://undraw.co/illustrations -->
					<div class="col-xl-6 col-md-6 col-sm-12 col-xs-12" style="cursor:pointer">
						<div class="card mb-3 m-3 hvr-bounce-to-right" style="overflow:hidden;text-overflow: ellipsis;min-height: 200px;">
							<a class="btn btn-danger position-absolute m-2 float-righ hvr-bob" title="Ver documentos" style="right:0px;z-index: 100;" data-toggle="modal" data-target="#modal_detalle" onclick="detalle(<?= $folder->folder_row_id ?>,'<?= $folder->folder_name ?>')"><i class="fa fa-eye text-white"></i></a>
							<div class="row g-0">
								<div class="col-md-4" style="vertical-align: middle;display: flex;justify-content: center;min-height: 200px;">
									<img src="<?php bloginfo('template_directory') ?><?= $folder->folder_url_img ?>" class="img-fluid rounded-start p-2" alt="<?= $folder->folder_name ?>">
								</div>
								<div class="col-md-8">
									<div class="card-body">
										<u>
											<h5 class="card-title font-weight-bold"><?= $folder->folder_name ?></h5>
										</u>
										<p class="card-text" title="<?= $folder->folder_description ?>" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Tooltip</em> <u>with</u> <b>HTML</b>"><?= substr($folder->folder_description, 0, 150) . (strlen($folder->folder_description) > 150 ? '...' : ''); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
	$oculta = 1;
	if ($oculta == "1") {
	?>
		<div class="rs-services style8 pt-120 pb-120 md-pt-80 md-pb-80">
			<div class="container">
				<div class="row align-items-center">
					<?php
					$post_id = 0;
					$args = [
						'numberposts' => 3,
						'offset' => 0,
						'category' => 0,
						'category_name' => 'pqr',
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
						$post_id = $recent_posts[0]['ID'];
						foreach ($recent_posts as $key => $recent) : $permalink = get_permalink($recent["ID"]);
							$thumbnail =  get_the_post_thumbnail($recent["ID"], 'slider_small_thumbs');
					?>
							<div class="col-lg-4 col-md-6 md-mb-30">
								<div class="services-item <?= $colors[($lineColor > count($colors) - 1 ? $lineColor = 0 : $lineColor)] ?>">
									<div class="text-right">
										<h6 class="p-0 m-0">Publicado el <?= date("Y-m-d H:i:s a", strtotime($recent['post_modified'])); ?></h6>
									</div>
									<div class="services-img hvr-bounce-out">
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
											<a href="<?php echo $permalink; ?>" class="read-more-post">Leer m??s...</a>
										</div>
									</div>
								</div>
							</div>

					<?php
							$lineColor++;
						endforeach;
					} ?>
					<?php //post random										

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
						'gray-light-bg',
						'pink-bg'
					];
					if (count($recent_posts) > 0) {
						$lineColor = $count = 1;
						foreach ($recent_posts as $key => $recent) : $permalink = get_permalink($recent["ID"]);
							$thumbnail =  get_the_post_thumbnail($recent["ID"], 'slider_small_thumbs');
							if ($recent["post_name"] != 'pqr' && $count<3) {
								$count++;
					?>			
								<div class="col-lg-4 col-md-6 md-mb-30">
									<div class="services-item <?= $colors[($lineColor > count($colors) - 1 ? $lineColor = 0 : $lineColor)] ?>">
										<div class="text-right">
											<h6 class="p-0 m-0">Publicado el <?= date("Y-m-d H:i:s a", strtotime($recent['post_modified'])); ?></h6>
										</div>
										<div class="services-img hvr-bounce-out">
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
												<a href="<?php echo $permalink; ?>" class="read-more-post">Leer m??s...</a>
											</div>
										</div>
									</div>
								</div>

					<?php
								$lineColor++;
							}
						endforeach;
					} ?>
				</div>
			</div>
		</div>

<?php
	}
}
?>
<!-- Services Section End -->
<!-- <.?php echo esc_html_x('Tags:', 'Label for a list of post tags', 'twentytwentyfour'); ?> -->

<?php
get_footer();
?>
<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>