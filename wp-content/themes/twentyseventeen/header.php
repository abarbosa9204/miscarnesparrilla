<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg" lang="zxx">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php bloginfo('name');
			echo ' | ';
			bloginfo('description'); ?></title>
	<meta name="description" content="">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preload" as="image" href="<?php bloginfo('template_directory') ?>/assets/images/f3J8GZemXMEKZksK9-200-x.webp">
	<script src="<?php bloginfo('template_directory') ?>/assets/js/jquery-3.5.1.js"></script>
	<!-- favicon -->
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory') ?>/assets/images/GaNWDXBZoSLTR8KNL-150-150.png">
	<!-- Bootstrap v4.4.1 css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/bootstrap.min.css">
	<!-- font-awesome css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/font-awesome.min.css">
	<!-- flaticon css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/fonts/flaticon.css">
	<!-- animate css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/animate.css">
	<!-- owl.carousel css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/owl.carousel.css">
	<!-- slick css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/slick.css">
	<!-- off canvas css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/off-canvas.css">
	<!-- magnific popup css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/magnific-popup.css">
	<!-- Main Menu css -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/assets/css/rsmenu-main.css">
	<!-- spacing css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/rs-spacing.css">
	<!-- responsive css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/responsive.css">
	<!-- jstree -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/assets/jstree/vendor/vakata/jstree/dist/themes/default/style.min.css" />

	<link href="<?php bloginfo('template_directory') ?>/assets/hover/hover.css" rel="stylesheet" media="all">
	<!-- style css -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/style.css"> <!-- This stylesheet dynamically changed from style.less -->
	<!-- <link rel="profile" href="https://gmpg.org/xfn/11"> -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> class="defult-home">
	<?php wp_body_open(); ?>
	<div class="offwrap"></div>
	<!--Preloader area start here-->
	<div id="loader" class="loader">
		<div class="loader-container"></div>
	</div>
	<!--Preloader area End here-->
	<div id="page" class="site">
		<!-- <a class="skip-link screen-reader-text" href="#content"><.?php _e('Skip to content', 'twentyseventeen'); ?></a> -->
		<div class="main-content">
			<div class="full-width-header">
				<header id="rs-header" class="rs-header style3 modify3 header-transparent">
					<div class="menu-area menu-sticky">
						<!-- container	 -->
						<div class="container">
							<div class="row-table">
								<div class="cell-col">
									<div class="logo-part">
										<a href="index.html">
											<img class="normal-logo" src="<?php bloginfo('template_directory') ?>/assets/images/logo-light.webp" alt="logo">
											<img class="sticky-logo" src="<?php bloginfo('template_directory') ?>/assets/images/logo-dark.webp" alt="logo">
										</a>
									</div>
									<div class="mobile-menu">
										<a href="#" class="rs-menu-toggle rs-menu-toggle-close">
											<i class="fa fa-bars"></i>
										</a>
									</div>
								</div>
								<div class="cell-col">
									<div class="rs-menu-area">
										<div class="main-menu">
											<nav class="rs-menu">
												<ul class="nav-menu">
													<li class="menu-item-has-children current-menu-item"></li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- container	 -->
					</div>
				</header><!-- #masthead -->
				<!-- Canvas Menu start -->
				<nav class="right_menu_togle hidden-md">
					<div class="close-btn">
						<div class="nav-link">
							<a id="nav-close" class="humburger nav-expander" href="#">
								<span class="dot1"></span>
								<span class="dot2"></span>
								<span class="dot3"></span>
								<span class="dot4"></span>
								<span class="dot5"></span>
								<span class="dot6"></span>
								<span class="dot7"></span>
								<span class="dot8"></span>
								<span class="dot9"></span>
							</a>
						</div>
					</div>
					<div class="canvas-logo">
						<a href="index.html"><img src="<?php bloginfo('template_directory') ?>/assets/images/logo-dark.webp" alt="logo"></a>
					</div>
					<div class="offcanvas-text">
						<p>Braintech quisque placerat vitae lacus ut scelerisque. Fusce luctus odio ac nibh luctus, in porttitor theo lacus egestas etiusto odio data center.</p>
					</div>
					<div class="canvas-contact">
						<div class="address-area">
							<div class="address-list">
								<div class="info-icon">
									<i class="flaticon-location"></i>
								</div>
								<div class="info-content">
									<h4 class="title">Address</h4>
									<em>05 kandi BR. New York</em>
								</div>
							</div>
							<div class="address-list">
								<div class="info-icon">
									<i class="flaticon-email"></i>
								</div>
								<div class="info-content">
									<h4 class="title">Email</h4>
									<em><a href="mailto:support@rstheme.com">support@rstheme.com</a></em>
								</div>
							</div>
							<div class="address-list">
								<div class="info-icon">
									<i class="flaticon-call"></i>
								</div>
								<div class="info-content">
									<h4 class="title">Phone</h4>
									<em>+019988772</em>
								</div>
							</div>
						</div>
						<ul class="social">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
				</nav>
			</div>

			<!-- Banner Section Start -->
			<div class="rs-banner style9">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<div class="banner-content">
								<span class="sub-text wow fadeinup2"></span>
								<h1 class="title wow fadeinup hvr-float-shadow">Bienvenido a su canal oficial institucional</h1>
								<p class="desc wow fadeinup">

								</p>

								<div class="btn-part">
									<?php
									if (is_user_logged_in()) {
										$href = 'wp-login.php?action=logout&wpnonce=3ae86f3016';
										$text = "Salir";
									} else {
										$href = "wp-login.php";
										$text = "Ingresar";
									}
									?>
									<a class="readon more-about hvr-bob" href="<?= $href ?>"><?= $text ?></a>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="images-part wow fadeInRight">
								<img src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/LogoMCP.png" alt="Logo miscarnesparrilla" style="width: 100%; height: auto;">
							</div>
						</div>
					</div>
				</div>
				<div class="banner-animation">
					<div class="bnr-animate one">
						<img class="rotated-style" src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/circle-1.png" alt="">
					</div>
					<div class="bnr-animate two">
						<img class="vertical" src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/circle-2.png" alt="">
					</div>
					<div class="bnr-animate three">
						<img class="horizontal" src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/circle-3.png" alt="">
					</div>
				</div>
			</div>
			
			<?php

			/*
			* If a regular post or page, and not the front page, show the featured image.
			* Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
			*/
			if ((is_single() || (is_page() && !twentyseventeen_is_frontpage())) && has_post_thumbnail(get_queried_object_id())) :
				//echo '<div class="single-featured-image-header">';
				//echo get_the_post_thumbnail(get_queried_object_id(), 'twentyseventeen-featured-image');
				//echo '</div><!-- .single-featured-image-header -->';
			endif;
			?>

			<div class="site-content-contain">
				<div id="content" class="site-content">