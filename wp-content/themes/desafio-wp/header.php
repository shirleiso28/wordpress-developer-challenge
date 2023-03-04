<?php
/**
 * Header - Cabeçalho do tema
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sp
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <?php // coloca cor no topo do mobile ?>
    <meta name="theme-color" content="#42AEE2">
    <meta name="msapplication-navbutton-color" content="#42AEE2">
    <meta name="apple-mobile-web-app-status-bar-style" content="#42AEE2">
    <meta name="format-detection" content="telephone=no">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header>
    <div class="container">
        <div class="row">
            <!-- Área do logo -->
            <div class="col-12 col-md-6 logo">
                <?php 
                    if(has_custom_logo()){
                        the_custom_logo();  
                    }
                ?>
            </div>
            <!-- Fim área do logo -->
            <!-- Área do menu desk-->
            <div class="col-12 col-md-6 menu-desk d-md-flex d-none">
                <?php 
                if(has_nav_menu('top')){
                    wp_nav_menu(array(
                        'theme_location' => 'top',
                        'container' => 'nav',
                        'container_class' => 'navbar',
                        'fallback_cb' => false,
                        'menu_class' => 'nav navbar-nav'
                    ));
                }
                ?>
            </div>
            <!-- Fim área menu desk--> 
        </div>
    </div>

</header>
<div class="wrap-page">