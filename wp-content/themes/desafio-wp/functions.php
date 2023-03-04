<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sp
 * 
 */
//Include - incluir arquivos de funções e configuração
require get_template_directory().'/include/enqueue.php';
require get_template_directory().'/include/setup.php';

//Hooks - adicionar as ações
/*Hooks essenciais*/

add_action("after_setup_theme","sp_after_setup"); //definição no arquivo setup
add_action("wp_enqueue_scripts","sp_theme_styles"); //definição no arquivo enqueue

/*Hooks e filtros extras*/
add_action('login_head', 'sp_custom_login_logo'); //definição no arquivo setup
add_filter( 'get_the_archive_title', 'remove_prefix_archive_title' ); //remover prefixos archive


/**
 * Load custom Components.
 */
require __DIR__ . '/include/custom-classes/custom-classes.php';

/**
 * Customizer additions.
 */
require __DIR__ . '/include/customizer.php';

/**
 * Rewrites url.
 */
/*require __DIR__.'/blog-url-rewrites.php';*/

/**
 * Load custom Post Types.
 */
require __DIR__ . '/include/post-types/post-types.php';
