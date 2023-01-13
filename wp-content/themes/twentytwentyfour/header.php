<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- meta tag -->
    <meta charset="utf-8">
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