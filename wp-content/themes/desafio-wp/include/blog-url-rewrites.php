<?php
/**
 * Add new rewrite rule
 */
function blog_url_rewrite() {

    // paginação do blog
    add_rewrite_rule('^videos/page/(\d+)/?','index.php?post_type=post&paged=$matches[1]','top');

    // paginação de categorias
    add_rewrite_rule('^videos/categoria/([^/]+)/page/([^/]*)/?','index.php?post_type=post&category_name=$matches[1]&paged=$matches[2]','top');

    // categorias
    add_rewrite_rule('^videos/categoria/([^/]*)/?','index.php?post_type=post&category_name=$matches[1]','top');

    // tags
    add_rewrite_rule('videos/tag/([^/]+)/?','index.php?post_type=post&tag=$matches[1]','top');

    // single post - ok
    add_rewrite_rule('^videos/([^/]*)/?','index.php?name=$matches[1]','top');

    // anotacoes-do-matofino archive
    add_rewrite_rule('^videos/?','index.php?post_type=post','top');

}
add_action('init', 'blog_url_rewrite', 999 );

/**
 * Modify post link
 */
function custom_post_link( $url, $post, $leavename ) {
    if ($post->post_type == 'post' ) {
        $url = home_url( user_trailingslashit( "videos/".$post->post_name ) );
    }
    return $url;
}
add_filter( 'post_link', 'custom_post_link', 10, 3 );



function custom_archive_link( $url, $post ) {
    if ( !is_admin() && $post->post_type == 'post' ) {
        if(is_array($post->post_category)) {
            $term     = get_term( $post->post_category[0] );
            $category = "categoria/".$term->slug."/";
        }else{
            $category = '';
        }
        $url = home_url( user_trailingslashit( "videos/".$category ) );
    }
    return $url;
}
add_filter( 'post_type_link', 'custom_archive_link', 10, 2 );

function custom_category_link( $url, $term, $taxonomy ) {
    if ( 'category' === $taxonomy ) {
        $url = home_url() . '/videos/categoria/' . $term->slug;
    }
    return $url;
}
add_filter( 'term_link', 'custom_category_link', 10, 3 );

/**
 * @param $query
 * @return mixed
 *
 * Ajusta a busca dentro do blog
 */
function blog_rewrite_templates() {
    global $wp_query;
    if($wp_query->query_vars['post_type'] == 'post'){
        add_filter( 'template_include', function () {
            return get_template_directory() . '/archive.php';
        });
    }
    if($wp_query->query_vars['name']){
        global $wpdb;
        if($post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".addslashes($wp_query->query_vars['name'])."'")){
            if(get_post_meta($post_id, "link", true) != "") {
                header( 'Location: ' . get_post_meta( $post_id, "link", true ), true, 301 );
                exit();
            }
        }
    }
}
add_action( 'template_redirect', 'blog_rewrite_templates' );
