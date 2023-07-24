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
<script src="<?php bloginfo('template_directory') ?>/assets/js/jquery-3.5.1.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/custom-bootstrap.css">
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
<!-- owl.carousel css -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/assets/css/dataTables.bootstrap5.min.css">
<!-- toast-->
<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/assets/toastr/css/toastr.min.css">
<script src="<?php bloginfo('template_directory') ?>/assets/toastr/js/toastr.min.js"></script>
<!-- jstree -->
<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/assets/jstree/vendor/vakata/jstree/dist/themes/default/style.min.css" />
<script src="<?php bloginfo('template_directory') ?>/assets/jstree/vendor/vakata/jstree/dist/jstree.min.js"></script>
<!-- style css -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory') ?>/style.css"> <!-- This stylesheet dynamically changed from style.less -->
<style>
        .dataTables_wrapper .dataTables_paginate {
                float: right;
                text-align: right;
                padding-top: 0.25em;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
                box-sizing: border-box;
                display: inline-block;
                min-width: 1.5em;
                padding: 0.5em 1em;
                margin-left: 2px;
                text-align: center;
                text-decoration: none !important;
                cursor: pointer;
                color: #333 !important;
                border: 1px solid transparent;
                border-radius: 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                color: #fff !important;
                background-color: #a5151d;
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #a5151d), color-stop(100%, #a5151d));
                background: -webkit-linear-gradient(top, #a5151d 0%, #a5151d 100%);
                background: -webkit-linear-gradient(top, #a5151d 0%, #a5151d 100%);
                background: linear-gradient(to bottom, #a5151d 0%, #a5151d 100%);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background-color: #878A8D;
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #878A8D), color-stop(100%, #878A8D));
                background: -webkit-linear-gradient(top, #878A8D 0%, #878A8D 100%);
                background: -webkit-linear-gradient(top, #878A8D 0%, #878A8D 100%);
                background: linear-gradient(to bottom, #878A8D 0%, #878A8D 100%);
                color: white !important;
        }
</style>