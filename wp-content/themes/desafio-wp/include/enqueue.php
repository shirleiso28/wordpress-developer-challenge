<?php
/**
 * Enqueue scripts and styles.
 * @package sp
 */


function sp_theme_styles()
{
    global $wp_query, $post;
    $appVersion = '0.0.5';
    $template_uri = get_template_directory_uri();

    $lazyLoadScripts = array();
    $lazyLoadStyles = array();


    //Carregamentos necessários
    //Registros de css
    wp_enqueue_style('sp-bootstrap-grid', $template_uri . '/assets/css/base/bootstrap-grid.min.css');
    wp_enqueue_style('sp-icones', $template_uri . '/assets/css/base/fa-min.css', array(), $appVersion);
    wp_enqueue_style('sp-style-base', $template_uri . '/assets/css/base/style.css', array(), $appVersion);
    wp_enqueue_style('sp-style-header-footer', $template_uri . '/assets/css/base/header-footer.css', array(), $appVersion);

    wp_enqueue_script('sp-script', $template_uri . '/assets/js/theme-script.js', array(), $appVersion, true);



    
    // swiper
    $lazyLoadScripts[] = $template_uri . '/assets/js/libs/swiper-bundle.min.js';
    $lazyLoadStyles[] = $template_uri . '/assets/css/libs/swiper-bundle.min.css';




    //Carregamentos condicionais
    if(is_front_page()){
        wp_enqueue_style('sp-home', $template_uri . '/assets/css/pages/home.css', array(), $appVersion);
        wp_enqueue_style('sp-video', $template_uri . '/assets/css/pages/parts/card-video.css', array(), $appVersion);
    }
    if(is_singular()){
        wp_enqueue_style('sp-single', $template_uri . '/assets/css/pages/single.css', array(), $appVersion);
        wp_enqueue_style('sp-video', $template_uri . '/assets/css/pages/parts/card-video.css', array(), $appVersion);
    }
    if(is_archive()){
        wp_enqueue_style('sp-archive', $template_uri . '/assets/css/pages/archive.css', array(), $appVersion);
        wp_enqueue_style('sp-video', $template_uri . '/assets/css/pages/parts/card-video.css', array(), $appVersion);
    }
    


    //depends lazyload
    $lazyLoadScripts[] = $template_uri . '/assets/js/depends-lazyload.js?ver='. $appVersion;

    sp_lazy_load($lazyLoadScripts, $lazyLoadStyles);
}



/*Atrasar o carregamento de alguns arquivos js e css para não pesar no carregamento da página*/
function sp_lazy_load($scripts=array(), $styles=array()){
    wp_enqueue_script(
        'sp-lazyload-scripts',
        get_template_directory_uri() . '/assets/js/splazyloading.js',
        array('jquery'),
        null,
        true
    );
    wp_localize_script( 'sp-lazyload-scripts', 'scripts', $scripts);
    wp_localize_script( 'sp-lazyload-scripts', 'styles', $styles);
}

function unset_script_src_by_handle($handle) {
    global $wp_scripts;
    if(in_array($handle, $wp_scripts->queue))
        unset($wp_scripts->registered[$handle]);

}
function unset_style_src_by_handle($handle) {
    global $wp_styles;
    if(in_array($handle, $wp_styles->queue))
        unset($wp_styles->registered[$handle]);

}

function get_script_src_by_handle($handle) {
    global $wp_scripts;
    if(in_array($handle, $wp_scripts->queue)) {
        return $wp_scripts->registered[$handle]->src;
    }
}

function get_dependecies_by_handle($handle){
    global $wp_scripts;
    $retorno = array();
    $wp_scripts->all_deps( $handle );
    foreach ( $wp_scripts->to_do as $dep_handle ) {
        $dep = $wp_scripts->registered[ $dep_handle ];
        $retorno[] = $dep->src;
    }
    return $retorno;
}

function get_style_src_by_handle($handle) {
    global $wp_styles;
    if(in_array($handle, $wp_styles->queue))
        return $wp_styles->registered[$handle]->src;

}
