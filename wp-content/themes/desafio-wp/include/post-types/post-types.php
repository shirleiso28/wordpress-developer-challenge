<?php
/**
 * Arquivo com funções comuns aos post_types
 *
 * @package sp
 */
// Carregamento dos custom post types
require_once __DIR__. '/Videos.php';

function set_post_meta($post_id, $meta_name, $request_name=false){
    $name_to_get_on_POST = $meta_name;
    if($request_name)
        $name_to_get_on_POST = $request_name;
    if (metadata_exists('post', $post_id, $meta_name)) { // If the custom field already has a value
        update_post_meta( $post_id, $meta_name, $_POST[$name_to_get_on_POST] );
    } else { // If the custom field doesn't have a value
        add_post_meta( $post_id, $meta_name, $_POST[$name_to_get_on_POST] );
    }
}
function create_nonce($post, $basename){
    echo '<input type="hidden" name="'.$post->post_type.'meta_noncename" id="'.$post->post_type.'meta_noncename" value="'.wp_create_nonce($basename) . '" />';
}
function verify_before_save_post_functions($post, $basename){
    //Verify nonce
    if (!isset($_POST[$post->post_type.'meta_noncename']) || !wp_verify_nonce( $_POST[$post->post_type.'meta_noncename'], $basename ))
        return false;
    // Verify if the user is allowed to edit the post or page
    if ( !current_user_can( 'edit_post', $post->ID ))
        return false;
    return true;
}
function get_the_first_term_name($post_id, $taxonomy){
    $terms = get_the_terms($post_id, $taxonomy);
    if(isset($terms[0]))
        return $terms[0]->name;
    return '';
}

function ajax_get_all_posts(){
    global $wpdb;
    $data = '*';
    if(isset($_POST['data']))
        $data = $_POST['data'];
    $order = 'ID DESC';
    if(isset($_POST['order']))
        $order = $_POST['order'];
    if(isset($_POST['post_type'])){
        $results = $wpdb->get_results("SELECT $data FROM ".$wpdb->posts." WHERE post_type = '".$_POST['post_type']."' ORDER BY $order");
        exit(json_encode(array('success' => true, 'results' => $results)));
    }
    exit(json_encode(array('success' => false)));
}
add_action( 'wp_ajax_get_all_posts', 'ajax_get_all_posts');

function save_conteudo_extras($post_id, $post) {
    if(!verify_before_save_post_functions($post, plugin_basename(__FILE__)))
        return $post->ID;
    set_post_meta($post->ID, 'link_externo');

}
add_action('save_post', 'save_conteudo_extras', 1, 2); // save the custom fields

