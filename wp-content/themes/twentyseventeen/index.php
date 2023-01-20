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
<div class="rs-services style8 pt-120 pb-120 md-pt-80 md-pb-80">
	<div class="container">
		<div class="sec-title2 text-center mb-50">
			<h2 class="title testi-title">
				Featured Brand Strategies and UX design
			</h2>
			<p class="desc desc3">
				Perspiciatis unde omnis iste natus error sit voluptatem accus antium doloremque laudantium, totam rem aperiam,
				eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
			</p>
		</div>
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
<!-- Services Section End -->
<!-- <.?php echo esc_html_x('Tags:', 'Label for a list of post tags', 'twentytwentyfour'); ?> -->
<!-- About Section Start -->
<div class="rs-about style5">
	<div class="about-bg pt-120 pb-120 md-pt-80 md-pb-80">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 md-mb-50">
					<div class="images-part">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/about/style3/1.png" alt="About">
					</div>
					<div class="about-animate">
						<img class="dance" src="<?php bloginfo('template_directory') ?>/assets/images/about/style3/2.png" alt="About">
					</div>
				</div>
				<div class="col-lg-6 pl-73 md-pl-15">
					<div class="sec-title4 mb-45 md-mb-0">
						<div class="title-img">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/bg/sob-bg.png" alt="">
						</div>
						<span class="sub-title">Our Strategy</span>
						<h2 class="title testi-title">We Build A Successful Brand Communication Strategy</h2>
						<div class="desc-part mb-43">
							Perspiciatis unde omnis iste natus error sit voluptatem accus antium dolo remque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequ untur magni dolores eos qui ratione voluptatem the breakpoint for tablet voluptatem the devices.
						</div>
						<div class="btn-part">
							<a class="readon more-about" href="about.html">Learn More</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- About Section End -->

<!-- Services Section Start -->
<div id="rs-services" class="rs-services style3 modify2 pt-120 pb-120 md-pt-80 md-pb-80">
	<div class="container">
		<div class="sec-title2 text-center mb-50">
			<h2 class="title testi-title">
				Creative Branding Strategy Services
			</h2>
			<p class="desc desc3">
				Perspiciatis unde omnis iste natus error sit voluptatem accus antium doloremque laudantium, totam rem aperiam,
				eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
			</p>
		</div>
		<div class="row">
			<div class="col-md-6 mb-20">
				<div class="services-item light-purple-bg">
					<div class="services-icon">
						<div class="image-part">
							<img class="main-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/main-img/6.png" alt="">
							<img class="hover-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/hover-img/6.png" alt="">
						</div>
					</div>
					<div class="services-content">
						<div class="services-text">
							<h3 class="title"><a href="web-development.html">Digital Strategies</a></h3>
						</div>
						<div class="services-desc">
							<p>
								We denounce with righteous indignation & dislike men who are so beguiled to righteous demorlized.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 mb-20">
				<div class="services-item light-purple-bg">
					<div class="services-icon">
						<div class="image-part">
							<img class="main-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/main-img/1.png" alt="">
							<img class="hover-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/hover-img/1.png" alt="">
						</div>
					</div>
					<div class="services-content">
						<div class="services-text">
							<h3 class="title"><a href="web-development.html">Brand Strategy</a></h3>
						</div>
						<div class="services-desc">
							<p>
								We denounce with righteous indignation & dislike men who are so beguiled to righteous demorlized
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 sm-mb-20">
				<div class="services-item light-purple-bg">
					<div class="services-icon">
						<div class="image-part">
							<img class="main-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/main-img/5.png" alt="">
							<img class="hover-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/hover-img/5.png" alt="">
						</div>
					</div>
					<div class="services-content">
						<div class="services-text">
							<h3 class="title"><a href="web-development.html">Brand Identity</a></h3>
						</div>
						<div class="services-desc">
							<p>
								We denounce with righteous indignation & dislike men who are so beguiled to righteous demorlized
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="services-item light-purple-bg">
					<div class="services-icon">
						<div class="image-part">
							<img class="main-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/main-img/2.png" alt="">
							<img class="hover-img" src="<?php bloginfo('template_directory') ?>/assets/images/services/style2/hover-img/2.png" alt="">
						</div>
					</div>
					<div class="services-content">
						<div class="services-text">
							<h3 class="title"><a href="web-development.html">UI/UX Design</a></h3>
						</div>
						<div class="services-desc">
							<p>
								We denounce with righteous indignation & dislike men who are so beguiled to righteous demorlized
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 text-center">
			<div class="btn-part wow fadeinup mt-45">
				<a class="readon more-about wow fadeinup" href="about.html">View More</a>
			</div>
		</div>
	</div>
	<!-- Partner Start -->
	<div class="rs-partner style4 modify1 pt-80 xs-pt-40">
		<div class="container">
			<div class="rs-carousel owl-carousel" data-loop="true" data-items="5" data-margin="30" data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="2" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="3" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="5" data-md-device-nav="false" data-md-device-dots="false">
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/1.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/1.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/2.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/2.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/3.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/3.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/4.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/4.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/5.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/5.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/6.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/6.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/7.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/7.png" alt="">
						</a>
					</div>
				</div>
				<div class="partner-item">
					<div class="logo-img">
						<a href="https://rstheme.com">
							<img class="hover-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/8.png" alt="">
							<img class="main-logo" src="<?php bloginfo('template_directory') ?>/assets/images/partner/style2/8.png" alt="">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Partner End -->
</div>
<!-- Services Section End -->

<!-- Slider Section Start -->
<div class="rs-slider style3 gray-bg2 pt-120 pb-215 md-pt-80 md-pb-0">
	<div class="container">
		<div class="sec-title2 text-center mb-50">
			<h2 class="title testi-title">
				The Pillars Of A Brand Strategy
			</h2>
			<p class="desc desc3">
				Perspiciatis unde omnis iste natus error sit voluptatem accus antium doloremque laudantium, totam rem aperiam,
				eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
			</p>
		</div>
		<div class="rs-carousel owl-carousel" data-loop="true" data-items="1" data-margin="0" data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="1" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="1" data-md-device-nav="true" data-md-device-dots="false">
			<div class="row align-items-center">
				<div class="col-lg-5 md-mb-50">
					<div class="image-part">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/about/style3/brand-visual.png" alt="">
					</div>
				</div>
				<div class="col-lg-7 pl-50 md-pl-15">
					<div class="slider-content">
						<div class="sec-title5 mb-20">
							<h2 class="title title2 pb-17">Brand Positioning</h2>
							<p class="desc2">Consistency in visual identity is key to brand retention. We will develop a brand style guide that will document and ensure a coherent use of your brand’s visual assets.Perspiciatis unde omnis iste natus error sit voluptatem accus antium dolo remque.</p>
						</div>
						<ul class="check-square">
							<li>Creating A Brand Strategy</li>
							<li>Determine A Brand’s Strengths & Weaknesses</li>
							<li>How Do Other Companies Compare?</li>
							<li>The Who, What, Where, When, Why & How’s</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-lg-5 md-mb-50">
					<div class="image-part">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/about/style3/brand-visual.png" alt="">
					</div>
				</div>
				<div class="col-lg-7 pl-50 md-pl-15">
					<div class="slider-content">
						<div class="sec-title5 mb-20">
							<h2 class="title title2 pb-17">Brand Messaging</h2>
							<p class="desc2">Consistency in visual identity is key to brand retention. We will develop a brand style guide that will document and ensure a coherent use of your brand’s visual assets.Perspiciatis unde omnis iste natus error sit voluptatem accus antium dolo remque.</p>
						</div>
						<ul class="check-square">
							<li>Creating A Brand Strategy</li>
							<li>Determine A Brand’s Strengths & Weaknesses</li>
							<li>How Do Other Companies Compare?</li>
							<li>The Who, What, Where, When, Why & How’s</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-lg-5 md-mb-50">
					<div class="image-part">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/about/style3/brand-visual.png" alt="">
					</div>
				</div>
				<div class="col-lg-7 pl-50 md-pl-15">
					<div class="slider-content">
						<div class="sec-title5 mb-20">
							<h2 class="title title2 pb-17">Brand Visual Identity</h2>
							<p class="desc2">Consistency in visual identity is key to brand retention. We will develop a brand style guide that will document and ensure a coherent use of your brand’s visual assets.Perspiciatis unde omnis iste natus error sit voluptatem accus antium dolo remque.</p>
						</div>
						<ul class="check-square">
							<li>Creating A Brand Strategy</li>
							<li>Determine A Brand’s Strengths & Weaknesses</li>
							<li>How Do Other Companies Compare?</li>
							<li>The Who, What, Where, When, Why & How’s</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-lg-5 md-mb-50">
					<div class="image-part">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/about/style3/brand-visual.png" alt="">
					</div>
				</div>
				<div class="col-lg-7 pl-50 md-pl-15">
					<div class="slider-content">
						<div class="sec-title5 mb-20">
							<h2 class="title title2 pb-17">Brand Audience</h2>
							<p class="desc2">Consistency in visual identity is key to brand retention. We will develop a brand style guide that will document and ensure a coherent use of your brand’s visual assets.Perspiciatis unde omnis iste natus error sit voluptatem accus antium dolo remque.</p>
						</div>
						<ul class="check-square">
							<li>Creating A Brand Strategy</li>
							<li>Determine A Brand’s Strengths & Weaknesses</li>
							<li>How Do Other Companies Compare?</li>
							<li>The Who, What, Where, When, Why & How’s</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Slider Section End -->

<!-- Counter Section Start -->
<div class="rs-counter style3 modify3 pt-90">
	<div class="container">
		<div class="counter-top-area">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-6 md-pb-50">
					<div class="counter-list">
						<div class="counter-text">
							<div class="count-number">
								<span class="rs-count">2051</span>
							</div>
							<h3 class="title">Projects</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 md-pb-50">
					<div class="counter-list">
						<div class="counter-text">
							<div class="count-number">
								<span class="rs-count plus">150</span>
							</div>
							<h3 class="title">Clients</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 xs-pb-50">
					<div class="counter-list">
						<div class="counter-text">
							<div class="count-number">
								<span class="rs-count plus">175</span>
							</div>
							<h3 class="title">Employees</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-list">
						<div class="counter-text">
							<div class="count-number">
								<span class="rs-count plus">250</span>
							</div>
							<h3 class="title">Awards</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Counter Section End -->

<!-- Project Section Start -->
<div class="rs-project style6 modify3 pt-120 pb-100 md-pt-80 md-pb-80">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="sec-title4 mb-45 md-mb-30 md-center">
					<div class="title-img">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/bg/sob-bg.png" alt="">
					</div>
					<span class="sub-title">Latest Projects</span>
					<h2 class="title testi-title">Branding Agency Case Studies</h2>
				</div>
			</div>
			<div class="col-lg-6 mb-30 md-mb-50 text-right md-center">
				<div class="btn-part">
					<a class="readon more-about" href="about.html">Learn More</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 mb-40">
				<div class="project-item">
					<div class="project-img">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/assets/images/project/style6/1.jpg" alt="images"></a>
					</div>
					<div class="project-content">
						<h3 class="title"><a href="case-studies-single.html">Creative Painting</a></h3>
						<span class="category"><a href="case-studies-single.html">Branding Agency</a></span>
					</div>
				</div>
			</div>
			<div class="col-md-6 mb-40">
				<div class="project-item">
					<div class="project-img">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/assets/images/project/style6/2.jpg" alt="images"></a>
					</div>
					<div class="project-content">
						<h3 class="title"><a href="case-studies-single.html">Event Marketing</a></h3>
						<span class="category"><a href="case-studies-single.html">Branding Agency</a></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="project-item">
					<div class="project-img">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/assets/images/project/style6/3.jpg" alt="images"></a>
					</div>
					<div class="project-content">
						<h3 class="title"><a href="case-studies-single.html">B2B Lead Generation</a></h3>
						<span class="category"><a href="case-studies-single.html">Branding Agency</a></span>
					</div>
				</div>
			</div>
			<div class="col-md-6 sm-mt-40">
				<div class="project-item">
					<div class="project-img">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/assets/images/project/style6/4.jpg" alt="images"></a>
					</div>
					<div class="project-content">
						<h3 class="title"><a href="case-studies-single.html">Brand Loyalty Built</a></h3>
						<span class="category"><a href="case-studies-single.html">Branding Agency</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Project Section End -->

<!-- Testimonial Section Start -->
<div class="rs-testimonial style9 gray-bg3 pt-120 pb-120 md-pt-80 md-pb-80">
	<div class="container">
		<div class="sec-title2 text-center mb-50">
			<h2 class="title testi-title">
				What Customer Saying
			</h2>
			<p class="desc desc3">
				Perspiciatis unde omnis iste natus error sit voluptatem accus antium doloremque laudantium, totam rem aperiam,
				eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
			</p>
		</div>
		<div class="rs-carousel owl-carousel" data-loop="true" data-items="2" data-margin="30" data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="true" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="true" data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="2" data-md-device-nav="false" data-md-device-dots="true">
			<div class="testi-item">
				<div class="testi-content">
					<div class="images-wrap">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/main-home/1.jpg" alt="Images">
					</div>
					<div class="testi-information">
						<div class="testi-name">Megan Fox</div>
						<span class="testi-title">CEO, Brick Consulting</span>
						<div class="ratings">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/style2/2.png" alt="Images">
						</div>
					</div>
				</div>
				<div class="item-content">
					<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>
				</div>
			</div>
			<div class="testi-item">
				<div class="testi-content">
					<div class="images-wrap">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/main-home/2.jpg" alt="Images">
					</div>
					<div class="testi-information">
						<div class="testi-name">Brie Larson</div>
						<span class="testi-title">Digital Marketer</span>
						<div class="ratings">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/style2/2.png" alt="Images">
						</div>
					</div>
				</div>
				<div class="item-content">
					<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>
				</div>
			</div>
			<div class="testi-item">
				<div class="testi-content">
					<div class="images-wrap">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/main-home/3.jpg" alt="Images">
					</div>
					<div class="testi-information">
						<div class="testi-name">Sushant Singh</div>
						<span class="testi-title">Graphic Designer</span>
						<div class="ratings">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/style2/2.png" alt="Images">
						</div>
					</div>
				</div>
				<div class="item-content">
					<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>
				</div>
			</div>
			<div class="testi-item">
				<div class="testi-content">
					<div class="images-wrap">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/main-home/4.jpg" alt="Images">
					</div>
					<div class="testi-information">
						<div class="testi-name">Varun Dhawan</div>
						<span class="testi-title">Design Lead</span>
						<div class="ratings">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/style2/2.png" alt="Images">
						</div>
					</div>
				</div>
				<div class="item-content">
					<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>
				</div>
			</div>
			<div class="testi-item">
				<div class="testi-content">
					<div class="images-wrap">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/main-home/5.jpg" alt="Images">
					</div>
					<div class="testi-information">
						<div class="testi-name">Shahid Kapoor</div>
						<span class="testi-title">Web Developer</span>
						<div class="ratings">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/style2/2.png" alt="Images">
						</div>
					</div>
				</div>
				<div class="item-content">
					<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>
				</div>
			</div>
			<div class="testi-item">
				<div class="testi-content">
					<div class="images-wrap">
						<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/main-home/1.jpg" alt="Images">
					</div>
					<div class="testi-information">
						<div class="testi-name">Angelina Jolie</div>
						<span class="testi-title">CEO, Brick Consulting</span>
						<div class="ratings">
							<img src="<?php bloginfo('template_directory') ?>/assets/images/testimonial/style2/2.png" alt="Images">
						</div>
					</div>
				</div>
				<div class="item-content">
					<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Testimonial Section End -->

<!-- Call Action Section Start -->
<div class="rs-call-action bg24 pb-70 pt-70">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-7">
				<div class="sec-title3 md-center md-mb-30">
					<span class="sub-text style2">Let's Chat</span>
					<h2 class="title title2">Have a Project, Let's Start Today.</h2>
				</div>
			</div>
			<div class="col-lg-5 text-right md-center">
				<div class="btn-part">
					<a class="readon more-about" href="about.html">Contact Us</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Call Action Section End -->
<!--end index origial -->
<?php
get_footer();
