<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- meta tag -->
    <meta charset="utf-8">
    <?php get_header();?>
    <title><?php bloginfo('name');
            echo ' | ';
            bloginfo('description'); ?></title>
    <meta name="description" content="">
    <link rel="preload" as="image" href="<?php bloginfo('template_directory') ?>/assets/images/f3J8GZemXMEKZksK9-200-x.webp">
    <!-- responsive tag -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/style.css"> <!-- This stylesheet dynamically changed from style.less -->
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/responsive.css">
    <!--[if lt IE 9]>
            <script src="<?php bloginfo('template_directory') ?>/https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="<?php bloginfo('template_directory') ?>/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="defult-home">
    <div class="offwrap"></div>
    <!--Preloader area start here-->
    <div id="loader" class="loader">
        <div class="loader-container"></div>
    </div>
    <!--Preloader area End here-->

    <!-- Main content Start -->
    <div class="main-content">

        <!--Full width header Start-->
        <div class="full-width-header">
            <!--Header Start-->
            <header id="rs-header" class="rs-header style3 modify3 header-transparent">
                <!-- Menu Start -->
                <div class="menu-area menu-sticky">
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
                                                <li class="menu-item-has-children current-menu-item">
                                                    <!-- <a href="index.html">Home</a> -->
                                                    <?php
                                                    wp_nav_menu(
                                                        array(
                                                            'theme_location' => 'menu_header',
                                                            'items_wrap'     => '%3$s<ul id="%1$s" class="sub-menu"><li class="menu-item-has-children current-menu-item">%3$s</li></ul>',
                                                            'container'      => false,
                                                            // 'depth'          => 1,
                                                            // 'link_before'    => '<span>',
                                                            // 'link_after'     => '</span>',
                                                            // 'fallback_cb'    => false,
                                                        )
                                                    );
                                                    ?>
                                                    <!-- <ul class="sub-menu">
                                                        <li class="menu-item-has-children current-menu-item">
                                                            <a href="#">Multipages</a>
                                                            <ul class="sub-menu">
                                                                <li><a href="index.html">Main Demo</a></li>
                                                                <li><a href="index2.html">Digital Agency 01</a></li>
                                                                <li><a href="index3.html">IT Solution 01</a></li>
                                                                <li><a href="index4.html">Digital Agency 02</a></li>
                                                                <li><a href="index5.html">Software Solution</a></li>
                                                                <li><a href="index6.html">Data Analysis</a></li>
                                                                <li><a href="index7.html">IT Solution 02</a></li>
                                                                <li><a href="index8.html">Gadgets Repairs</a></li>
                                                                <li><a href="index9.html">Application Testing</a></li>
                                                                <li><a href="index10.html">IT Solution 03</a></li>
                                                                <li><a href="index11.html">Digital Agency Dark</a></li>
                                                                <li><a href="index12.html">Web Design Agency</a></li>
                                                                <li class="active"><a href="index13.html">Branding Agency</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="#">Onepages</a>
                                                            <ul class="sub-menu">
                                                                <li><a href="onepage1.html">Main Demo</a></li>
                                                                <li><a href="onepage2.html">Digital Agency 01</a></li>
                                                                <li><a href="onepage3.html">IT Solution 01</a></li>
                                                                <li><a href="onepage4.html">Digital Agency 02</a></li>
                                                                <li><a href="onepage5.html">Software Solution</a></li>
                                                                <li><a href="onepage6.html">Data Analysis</a></li>
                                                                <li><a href="onepage7.html">IT Solution 02</a></li>
                                                                <li><a href="onepage8.html">Gadgets Repairs</a></li>
                                                                <li><a href="onepage9.html">Application Testing</a></li>
                                                                <li><a href="onepage10.html">IT Solution 03</a></li>
                                                                <li><a href="onepage11.html">Digital Agency Dark</a></li>
                                                                <li><a href="onepage12.html">Web Design Agency</a></li>
                                                                <li><a href="onepage13.html">Branding Agency</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul> -->
                                                </li>
                                                <li>
                                                    <a href="about.html">About</a>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">Services</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="software-development.html">Software Development</a> </li>
                                                        <li><a href="web-development.html">Web Development</a> </li>
                                                        <li><a href="analytic-solutions.html">Analytic Solutions</a> </li>
                                                        <li><a href="product-design.html">Cloud and DevOps</a></li>
                                                        <li><a href="project-design.html">Project Design</a> </li>
                                                        <li><a href="data-center.html">Data Center</a> </li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">Pages</a>
                                                    <ul class="sub-menu">
                                                        <li class="menu-item-has-children">
                                                            <a href="#">Services</a>
                                                            <ul class="sub-menu right">
                                                                <li><a href="services1.html">Services 1</a></li>
                                                                <li><a href="services2.html">Services 2</a></li>
                                                                <li><a href="services3.html">Services 3</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="our-team.html">Our Team</a>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="single-team.html">Single Team</a>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="#">Case Studies</a>
                                                            <ul class="sub-menu right">
                                                                <li><a href="case-studies-style1.html">Case Studies Style 1</a></li>
                                                                <li><a href="case-studies-style2.html">Case Studies Style 2</a></li>
                                                                <li><a href="case-studies-style3.html">Case Studies Style 3</a></li>
                                                                <li><a href="case-studies-style4.html">Case Studies Style 4</a></li>
                                                                <li><a href="case-studies-style5.html">Case Studies Style 5</a></li>
                                                                <li><a href="case-studies-style6.html">Case Studies Style 6</a></li>
                                                                <li><a href="case-studies-style7.html">Case Studies Style 7</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="shop.html">Shop</a>
                                                            <ul class="sub-menu right">
                                                                <li><a href="shop.html">Shop</a></li>
                                                                <li><a href="shop-single.html">Shop Single</a></li>
                                                                <li><a href="cart.html">Cart</a></li>
                                                                <li><a href="checkout.html">Checkout</a></li>
                                                                <li><a href="my-account.html">My Account</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="pricing.html">Pricing</a>
                                                        </li>
                                                        <li class="menu-item-has-children">
                                                            <a href="faq.html">Faq</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="blog.html">Blog</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="blog.html">Blog</a> </li>
                                                        <li><a href="blog-details.html">Blog Details</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="contact.html">Contact</a>
                                                </li>
                                            </ul> <!-- //.nav-menu -->
                                        </nav>
                                    </div> <!-- //.main-menu -->
                                </div>
                            </div>
                            <div class="cell-col">
                                <div class="expand-btn-inner search-icon hidden-md">
                                    <ul>
                                        <li class="sidebarmenu-search">
                                            <a class="hidden-xs rs-search" data-target=".search-modal" data-toggle="modal" href="#">
                                                <i class="flaticon-search"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a id="nav-expander" class="humburger nav-expander" href="#">
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
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Menu End -->
            </header>
            <!--Header End-->

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
            <!-- Canvas Menu end -->
        </div>
        <!--Full width header End-->

        <!-- Banner Section Start -->
        <div class="rs-banner style9">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="banner-content">
                            <span class="sub-text wow fadeinup2">Branding Agency</span>
                            <h1 class="title wow fadeinup">The Unifying Power of Branding</h1>
                            <p class="desc wow fadeinup">
                                We Are Modern Creative Agency, We Create Your Drem & Creating Consistency in Professional Services Branding
                            </p>
                            <div class="btn-part">
                                <a class="readon more-about" href="about.html">More About</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="images-part wow fadeInRight">
                            <img src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/image.png" alt="">
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
                <div class="bnr-animate four">
                    <img class="vertical" src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/shape-1.png" alt="">
                </div>
                <div class="bnr-animate five">
                    <img class="horizontal new-style" src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/shape-2.png" alt="">
                </div>
                <div class="bnr-animate six">
                    <img class="horizontal" src="<?php bloginfo('template_directory') ?>/assets/images/banner/style4/shape-2.png" alt="">
                </div>
            </div>
        </div>
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
                                                <img src="..." alt="Sin imagen" class="wp-image-25" width="838" height="513">
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

    </div>
    <!-- Main content End -->

    <!-- Footer Start -->
    <footer id="rs-footer" class="rs-footer style3">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 footer-widget">
                        <div class="footer-logo mb-30">
                            <a href="index.html"><img src="<?php bloginfo('template_directory') ?>/assets/images/logo-dark.webp" alt=""></a>
                        </div>
                        <div class="textwidget pb-30">
                            <p>Sedut perspiciatis unde omnis iste natus error sitlutem acc usantium doloremque denounce with illo inventore veritatis</p>
                        </div>
                        <ul class="footer-social md-mb-30">
                            <li>
                                <a href="#" target="_blank"><span><i class="fa fa-facebook"></i></span></a>
                            </li>
                            <li>
                                <a href="# " target="_blank"><span><i class="fa fa-twitter"></i></span></a>
                            </li>

                            <li>
                                <a href="# " target="_blank"><span><i class="fa fa-pinterest-p"></i></span></a>
                            </li>
                            <li>
                                <a href="# " target="_blank"><span><i class="fa fa-instagram"></i></span></a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 pl-45 md-pl-15 md-mb-30">
                        <h3 class="widget-title">IT Services</h3>
                        <ul class="site-map">
                            <li><a href="software-development.html">Software Development</a></li>
                            <li><a href="web-development.html">Web Development</a></li>
                            <li><a href="analytic-solutions.html">Analytic Solutions</a></li>
                            <li><a href="cloud-and-devops.html">Cloud and DevOps</a></li>
                            <li><a href="product-design.html">Product Design</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 md-mb-30">
                        <h3 class="widget-title">Contact Info</h3>
                        <ul class="address-widget">
                            <li>
                                <i class="flaticon-location"></i>
                                <div class="desc">374 FA Tower, William S Blvd 2721, IL, USA</div>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <div class="desc">
                                    <a href="tel:(+880)155-69569">(+880)155-69569</a>
                                </div>
                            </li>
                            <li>
                                <i class="flaticon-email"></i>
                                <div class="desc">
                                    <a href="mailto:support@rstheme.com">support@rstheme.com</a>
                                </div>
                            </li>
                            <li>
                                <i class="flaticon-clock-1"></i>
                                <div class="desc">
                                    Opening Hours: 10:00 - 18:00
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12">
                        <h3 class="widget-title">Newsletter</h3>
                        <p class="widget-desc">We denounce with righteous and in and dislike men who are so beguiled and demo realized.</p>
                        <p>
                            <input type="email" name="EMAIL" placeholder="Your email address" required="">
                            <em class="paper-plane"><input type="submit" value="Sign up"></em>
                            <i class="flaticon-send"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-6 text-right md-mb-10 order-last">
                        <ul class="copy-right-menu">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="shop.html">Shop</a></li>
                            <li><a href="faq.html">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="copyright">
                            <p>&copy; 2021 All Rights Reserved. Developed By <a href="http://rstheme.com/">RSTheme</a></p>
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
    <!-- modernizr js -->
    <script src="<?php bloginfo('template_directory') ?>/assets/js/modernizr-2.8.3.min.js"></script>
    <!-- jquery latest version -->
    <script src="<?php bloginfo('template_directory') ?>/assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap v4.4.1 js -->
    <script src="<?php bloginfo('template_directory') ?>/assets/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
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
</body>
<?php wp_footer(); ?>

</html>