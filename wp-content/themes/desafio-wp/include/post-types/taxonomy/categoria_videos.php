<?php

// Cria taxonomia categoria_videos
function registrar_tax_categoriaVideos() {
    register_taxonomy(
        'categoria_videos', array( 'videos' ),
        array(
            'hierarchical' => true,
            'label' => 'Categoria Videos',
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => true,
            'labels' => array (
                'search_items' => 'Categorias',
                'popular_items' => 'Principais Categorias',
                'all_items' => 'Todas as Categorias',
                'edit_item' => 'Editar Categoria',
                'update_item' => 'Atualizar Categoria',
                'add_new_item' => 'Adicionar Categoria'
            ),
            'sort' => true,
            'rewrite' => array( 'slug' => 'videos', 'with_front' => false, 'hierarchical' => true ),
            'has_archive' => 'videos',
            'show_in_rest'      => true,
        )
    );
}
add_action('init', 'registrar_tax_categoriaVideos');