<?php
/* Smarty version 3.1.33, created on 2024-07-16 12:17:28
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\homeRU.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_669648b855b352_80236529',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be74bb0ab98886899c29b2235d5e4e4988160913' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\homeRU.tpl',
      1 => 1721124983,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669648b855b352_80236529 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gym | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/style.css" type="text/css">

    <?php echo '<script'; ?>
>
        function ready(){
            if (!navigator.cookieEnabled) {
                alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
            }
        }
        document.addEventListener("DOMContentLoaded", ready);
    <?php echo '</script'; ?>
>
</head>

<body>
    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="/GymBuddy/User/home">Home</a></li>
                <li><a href="/GymBuddy/Home/about-us">About Us</a></li>
                <li><a href="/GymBuddy/Home/services">Services</a></li>
                <li><a href="/GymBuddy/Home/team">Our Team</a></li>
                <li><a href="#">Pages</a>
                    <ul class="dropdown">
                        <li><a href="/GymBuddy/Home/gallery">Gallery</a></li>
                        <li><a href="/GymBuddy/Home/blog">Our blog</a></li>
                        <li><a href="/GymBuddy/Home/404">404</a></li>
                    </ul>
                </li>
                <li><a href="/GymBuddy/Home/contact">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="/GymBuddy/User/home">
                            <img src="/GymBuddy/libs/Smarty/img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li class="active"><a href="/GymBuddy/User/home">Home</a></li>
                            <li><a href="/GymBuddy/Home/about-us">About Us</a></li>
                            <li><a href="/GymBuddy/Home/services">Services</a></li>
                            <li><a href="/GymBuddy/Home/team">Our Team</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="/GymBuddy/Home/gallery">Gallery</a></li>
                                    <li><a href="/GymBuddy/Home/blog">Our blog</a></li>
                                    <li><a href="/GymBuddy/Home/404">404</a></li>
                                </ul>
                            </li>
                            <li><a href="/GymBuddy/Home/contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="to-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                        <!-- Aggiunta del pulsante di login -->
                        <a href="/GymBuddy/User/logout" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    <section class="hero-section" style="background-image: url('/GymBuddy/libs/Smarty/img/hero/hero-2.jpg'); background-size: cover; background-position: center center; height: 100vh; display: flex; align-items: flex-end; justify-content: flex-end;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="hi-text" style="margin-bottom: 250px; margin-left: 50px;">
                        <span style="color: white; text-transform: uppercase;">Shape your body</span>
                        <h1 style="color: white; text-transform: uppercase;">Be <strong style="color: orange; text-transform: uppercase;">strong</strong> training hard</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Rest of the template... -->

    <!-- Js Plugins -->
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery.magnific-popup.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/masonry.pkgd.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery.barfiller.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery.slicknav.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/owl.carousel.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/main.js"><?php echo '</script'; ?>
>

</body>

</html><?php }
}
