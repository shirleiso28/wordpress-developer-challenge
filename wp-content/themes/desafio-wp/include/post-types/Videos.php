<?php
/**
 * CUSTOM POST TYPE: Videos
 */

function videos_post_type() {
    $labels = array(
        'name'                => 'Vídeos',
        'singular_name'       => 'Vídeo',
        'menu_name'           => 'Vídeos',
        'parent_item_colon'   => '',
        'all_items'           => 'Listagem',
        'view_item'           => 'Ver Vídeo',
        'add_new_item'        => 'Adicionar Vídeo',
        'add_new'             => 'Adicionar',
        'edit_item'           => 'Editar Vídeo',
        'update_item'         => 'Atualizar Vídeo',
        'search_items'        => 'Buscar Vídeo',
        'not_found'           => 'Nenhum Vídeo encontrado',
        'not_found_in_trash'  => 'Nenhum Vídeo encontrado na lixeira',
    );

    $rewrite = array(
        'slug'                => 'videos',
        'with_front'          => false,
        'pages'               => false,
        'feeds'               => false,
    );

    $args = array(
        'label'               => 'videos',
        'description'         => 'Página com vídeos',
        'labels'              => $labels,
        'show_in_rest'        => true, // gutenberg
        'supports'            => array('title','editor','thumbnail'),
        'taxonomies'          => array('categoria_videos'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 6,
        'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDUxMiA1MTIiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48cGF0aCBmaWxsPSIjYTdhYWFkIiBkPSJNMjYwLjQsNDQ5Yy01Ny4xLTEuOC0xMTEuNC0zLjItMTY1LjctNS4zYy0xMS43LTAuNS0yMy42LTIuMy0zNS01Yy0yMS40LTUtMzYuMi0xNy45LTQzLjgtMzljLTYuMS0xNy04LjMtMzQuNS05LjktNTIuMyAgIEMyLjUsMzA1LjYsMi41LDI2My44LDQuMiwyMjJjMS0yMy42LDEuNi00Ny40LDcuOS03MC4zYzMuOC0xMy43LDguNC0yNy4xLDE5LjUtMzdjMTEuNy0xMC41LDI1LjQtMTYuOCw0MS0xNy41ICAgYzQyLjgtMi4xLDg1LjUtNC43LDEyOC4zLTUuMWM1Ny42LTAuNiwxMTUuMywwLjIsMTcyLjksMS4zYzI0LjksMC41LDUwLDEuOCw3NC43LDVjMjIuNiwzLDM5LjUsMTUuNiw0OC41LDM3LjYgICBjNi45LDE2LjksOS41LDM0LjYsMTEsNTIuNmMzLjksNDUuMSw0LDkwLjIsMS44LDEzNS4zYy0xLjEsMjIuOS0yLjIsNDUuOS04LjcsNjguMmMtNy40LDI1LjYtMjMuMSw0Mi41LTQ5LjMsNDguMyAgIGMtMTAuMiwyLjItMjAuOCwzLTMxLjIsMy40QzM2Ni4yLDQ0NS43LDMxMS45LDQ0Ny40LDI2MC40LDQ0OXogTTIwNS4xLDMzNS4zYzQ1LjYtMjMuNiw5MC43LTQ3LDEzNi43LTcwLjkgICBjLTQ1LjktMjQtOTEtNDcuNS0xMzYuNy03MS40QzIwNS4xLDI0MC43LDIwNS4xLDI4Ny42LDIwNS4xLDMzNS4zeiIvPjwvZz48L3N2Zz4=',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );

    register_post_type( 'videos', $args );

}
add_action( 'init', 'videos_post_type', 0 );

require_once __DIR__. '/taxonomy/categoria_videos.php';

new CustomThumbs('img_banner', 'Imagem para banner 1920 x 1000', 'videos', 'side');
new CustomTextField('txt_length', 'Duração (em minutos. Ex: 120m)', 'videos','side');
new CustomLinkField('url_youtube', 'URL vídeo (youtube)','videos','normal');

