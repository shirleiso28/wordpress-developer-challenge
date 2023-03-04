<?php
/**
 * Configurações gerais do tema.
 * @package sp
 */

if (!function_exists('sp_after_setup')){
    /**
     * Configura os padrões do tema e registra o suporte para vários recursos do WordPress 
     */
    function sp_after_setup(){
        /*Ativação de elementos essenciais ao tema*/
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support("custom-logo");
        add_theme_support("post-formats", array( 'video', 'audio' ));

        // adiciona tamanho padrão para capas dos videos
        add_image_size( 'img_capa', 248, 387, true );

        /*Registro de menu*/
        register_nav_menu("top", "Menu Superior");
        register_nav_menu("bottom", "Menu Mobile");
    }
}


/**
 * Customização do login
 */
function sp_custom_login_logo() {
    echo '
    <style type="text/css">
    
    .login h1 a{
        background-image:url('.get_theme_mod( 'admin_logo' ).') !important;
        background-size: 50% auto;
        width: 326px;
        height: 55px;
    }
    
    body.login, html{
        background-color:#FFFFFF !important;
    }
    
    .wp-core-ui .button-primary{
        color:#fff;
        background:#000;
        box-shadow: none;border:none;
        text-shadow: none;
    }
    .wp-core-ui .button-primary:hover,
    .wp-core-ui .button-primary:active,
    .wp-core-ui .button-primary:focus{
        color:#fff;
        background:#FF0000;
        box-shadow: none;
        outline:0 !important;
    }
    #wp-auth-check-wrap #wp-auth-check{
        background:#FF0000;
    }
    
    .login .message{
        border-left: 4px solid #000;
    }
    .login form{
        box-shadow:none;
        border:solid 1px #000;
    }
    .login #nav a,.login #backtoblog a{
        color:#000;
    }
    .login #nav a:hover,.login #backtoblog a:hover{
        color:#000;text-decoration:underline;
    }

    </style>';
}


/**
 * Remover prefixos da Archive
 * 
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
function remove_prefix_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title  = get_the_author();
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
}