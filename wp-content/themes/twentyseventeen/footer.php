<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.2
 */

?>
</div><!-- main-content -->
</div><!-- #content -->
<!-- <footer id="colophon" class="site-footer"> -->
<footer id="rs-footer" class="site-footer rs-footer style3">
	<div class="wrap footer-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-12 col-sm-12 footer-widget">
					<div class="footer-logo mb-30">
						<a href="index.html"><img src="<?php bloginfo('template_directory') ?>/assets/images/logo-dark.webp" alt="" width="150px" style="height:auto"></a>
					</div>
					<div class="textwidget">
						<!--p>Sedut perspiciatis unde omnis iste natus error sitlutem acc usantium doloremque denounce with illo inventore veritatis</p-->
					</div>
					<ul class="footer-social md-mb-30">
						<li>
							<a href="https://m.facebook.com/miscarnes" target="_blank"><span><i class="fa fa-facebook"></i></span></a>
						</li>
						<li>
							<a href="https://twitter.com/MisCarnesP" target="_blank"><span><i class="fa fa-twitter"></i></span></a>
						</li>

						<!--li>
									<a href="# " target="_blank"><span><i class="fa fa-pinterest-p"></i></span></a>
								</li-->
						<li>
							<a href="https:www.instagram.com/miscarnesparrilla" target="_blank"><span><i class="fa fa-instagram"></i></span></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row y-middle">
				<div class="col-lg-6">
					<div class="copyright">
						<p>&copy; 2022 All Rights Reserved. Developed By Theme C&A GEMASOFT</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer End -->

<!-- start scrollUp  -->
<div id="scrollUp" class="purple-color">
	<i class="fa fa-angle-up"></i>
</div>
<!-- End scrollUp  -->

<!-- Search Modal Start -->
<div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span class="flaticon-cross"></span>
	</button>
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="search-block clearfix">
				<form>
					<div class="form-group">
						<input class="form-control" placeholder="Search Here..." type="text">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Search Modal End -->
<!-- Modal Arbol Start-->
<div class="modal fade bd-example-modal-xl" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="modal_detalle" data-backdrop="static">
	<div class="modal-content modal-dialog modal-xl" role="document" style="border-radius: 5px;">
		<div class="modal-header box bg-danger">
			<h5 class="modal-title text-white" id="tituloCarpeta"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="box-title item-titulo text-muted"></h4>
		</div>
		<div class="modal-body">
			<a href="#" class="download-file-jstree" target="_blank" style="display: none;" download></a>
			<div class="row" style="padding: 2px">
				<div class="col-sm-12" id="tablaDetalleCarpeta">
				</div>
			</div>
		</div>
		<div class="modal-footer" style="margin-top:0px">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-6">
						<button type="reset" class="btn btn-danger btn-sm btn-block twentyseventeen-font-size-theme-15-5" data-dismiss='modal' style="width: 100px;">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div><!-- .site-content-contain -->
</div><!-- #page -->
<!-- Modal Arbol End -->
<!-- modernizr js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/modernizr-2.8.3.min.js"></script>
<!-- jquery latest version -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Bootstrap v4.4.1 js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/bootstrap.min.js"></script>
<!--script src="<?php bloginfo('template_directory') ?>/assets/tree/jstree.min.js"></script-->
<script src="<?php bloginfo('template_directory') ?>/assets/jstree/vendor/vakata/jstree/dist/jstree.min.js"></script>
<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});


	function detalle(carpeta, titulo) {
		if (carpeta > 0) {
			arbol = carpeta;
			$("#tituloCarpeta").empty();
			$("#tituloCarpeta").html(titulo);
			$("#tablaDetalleCarpeta").empty();
			$("#tablaDetalleCarpeta").append('<div id="' + arbol + '"></div>');
			$('#' + arbol).jstree({
				"animation": 0,
				"themes": {
					"stripes": true
				},
				"core": {
					"themes": {
						"responsive": true
					},
					"data": {
						type: "POST",
						url: ajax_var.url,
						dataType: "json",
						data: {
							id: arbol,
							node: 'parentNode',
							search: 1,
							action: ajax_var.action,
							nonce: ajax_var.nonce

						},
						success: function(data) {}
					},
					'callback': true,
					"plugins": [
						"contextmenu", "dnd", "search",
						"state", "types", "wholerow"
					]
				}
			});
			$('#' + arbol).on("select_node.jstree", function(e, data) {
				//createNode(1, "last", arbol);
				//console.log("sas");
				//console.log(data.node.children.length);
				e.preventDefault();
			});
		}
	}

	function downloadFile(url, status, ext) {
		if (status === true) {
			switch (ext) {
				case '.pdf':
					window.open(url);
					break;
				case '.php':
					if ($('#modal_detalle').is(':visible')) {
						$('#modal_detalle').modal('hide').data('bs.modal', null);
					}
					$('#iframe-video-view').modal('show')
					let html = '<iframe class="responsive-video" src="' + url + '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" webkitallowfullscreen="true" mozallowfullscreen="true" oallowfullscreen="true" msallowfullscreen="true"></iframe>';
					$('.video-iframe').html(html);
					break;
				default:
					$('.download-file-jstree').attr('href', url);
					window.location.href = $('.download-file-jstree').attr('href');
					break;
			}
		}
	}

	function resetIframe(action) {
		switch (action) {
			case 'reset':
				$('#iframe-video-view').modal('hide').data('bs.modal', null);
				$('.video-iframe').html('');
				break;
		}
	}
</script>
<!-- Menu js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/rsmenu-main.js"></script>
<!-- op nav js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/jquery.nav.js"></script>
<!-- owl.carousel js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/owl.carousel.min.js"></script>
<!-- wow js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/wow.min.js"></script>
<!-- Skill bar js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/skill.bars.jquery.js"></script>
<script src="<?php bloginfo('template_directory') ?>/assets/js/jquery.counterup.min.js"></script>
<!-- counter top js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/waypoints.min.js"></script>
<!-- swiper js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/swiper.min.js"></script>
<!-- particles js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/particles.min.js"></script>
<!-- magnific popup js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/jquery.magnific-popup.min.js"></script>
<!-- plugins js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/plugins.js"></script>
<!-- pointer js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/pointer.js"></script>
<!-- contact form js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/contact.form.js"></script>
<!-- main js -->
<script src="<?php bloginfo('template_directory') ?>/assets/js/main.js"></script>
<?php wp_footer(); ?>
</body>
</html>