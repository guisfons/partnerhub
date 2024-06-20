<?php
/**
 * Declare all used post types
 */
function ks_register_post_types(){

    $def_posttype_args = array(

        'labels'             => array(),
        'description'        => '',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => '',
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'supports'           => array('title', 'thumbnail', 'editor', 'author', 'excerpt', 'page-attributes' ),
        'show_in_rest'		 => true

    );

    $def_taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => array(),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => '',
        'show_in_rest'		 => true,
        'show_in_quick_edit' => true,
    );

    $posttypes = array(

        'hotels' => array(

            'labels' => array(
                'name'               => __('Hotels'),
                'singular_name'      => __('Hotel'),
                'menu_name'          => __('Hotels'),
                'name_admin_bar'     => __('Hotels'),
                'add_new'            => __('New Hotel'),
                'add_new_item'       => __('New Hotel'),
                'new_item'           => __('New Hotel'),
                'edit_item'          => __('Edit Hotel'),
                'view_item'          => __('See Hotel'),
                'all_items'          => __('Hotels'),
                'search_items'       => __('Search Hotels'),
                'parent_item_colon'  => __('Hotels parent:'),
                'not_found'          => __('No Hotel found.'),
                'not_found_in_trash' => __('No Hotel found in bin.')
            ),
            'menu_icon' => 'dashicons-building',
            'description' => __('Hotels'),
            'rest_base' =>'custom/hotels',
            'has_archive' => 'biblioteca/hotels',
            'rewrite'     => [
                'slug' => 'hotels',
            ],
            'supports'    => array('title', 'thumbnail'),
            'show_in_rest' => false,  // @info inherited from old version
        ),

        // 'tickets' => array(

        //     'labels' => array(
        //         'name'               => __('Tickets'),
        //         'singular_name'      => __('Ticket'),
        //         'menu_name'          => __('Tickets'),
        //         'name_admin_bar'     => __('Tickets'),
        //         'add_new'            => __('New Ticket'),
        //         'add_new_item'       => __('New Ticket'),
        //         'new_item'           => __('New Ticket'),
        //         'edit_item'          => __('Edit Ticket'),
        //         'view_item'          => __('See Ticket'),
        //         'all_items'          => __('Tickets'),
        //         'search_items'       => __('Search for Tickets'),
        //         'parent_item_colon'  => __('Tickets parent:'),
        //         'not_found'          => __('No Ticket found.'),
        //         'not_found_in_trash' => __('No Ticket found in bin.')
        //     ),
        //     'menu_icon' => 'dashicons-tickets',
        //     'description' => __('Tickets'),
        //     'rest_base' =>'custom/tickets',
        //     'has_archive' => 'biblioteca/tickets',
        //     'rewrite'     => [
        //         'slug' => 'tickets',
        //     ],
        //     'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
        //     'taxonomy'    => array(

        //         'tickets_categories' => array(

        //             'hierarchical'      => true,
        //             'labels'            => array(
        //                 'name'              => __('Categorias'),
        //                 'singular_name'     => __('Categoria'),
        //                 'search_items'      => __('Procurar por categoria' ),
        //                 'all_items'         => __('Categorias' ),
        //                 'parent_item'       => __('Categoria Pai' ),
        //                 'parent_item_colon' => __('Categorias Pai:' ),
        //                 'edit_item'         => __('Editar Categoria' ),
        //                 'update_item'       => __('Atualizar Categoria' ),
        //                 'add_new_item'      => __('Nova Categoria' ),
        //                 'new_item_name'     => __('Nova Categoria' ),
        //                 'menu_name'         => __('Categorias' ),
        //             ),

        //             'show_ui'           => true,
        //             'show_admin_column' => true,
        //             'query_var'         => true,
		// 			'rewrite'           => array('slug' => 'tickets/categorias'),
		// 			'show_in_rest'      => true,
        //             'rest_base'         => 'tickets'
        //         ),
        //     ),
        //     'show_in_rest' => false,  // @info inherited from old version
        // ),

        'notifications' => array(

            'labels' => array(
                'name'               => __('Notifications'),
                'singular_name'      => __('Notification'),
                'menu_name'          => __('Notifications'),
                'name_admin_bar'     => __('Notifications'),
                'add_new'            => __('New Notification'),
                'add_new_item'       => __('New Notification'),
                'new_item'           => __('New Notification'),
                'edit_item'          => __('Edit Notification'),
                'view_item'          => __('See Notification'),
                'all_items'          => __('Notifications'),
                'search_items'       => __('Search for Notifications'),
                'parent_item_colon'  => __('Notifications parent:'),
                'not_found'          => __('No Notification found.'),
                'not_found_in_trash' => __('No Notification found in bin.')
            ),
            'menu_icon' => 'dashicons-bell',
            'description' => __('Notifications'),
            'rest_base' =>'custom/notifications',
            'has_archive' => 'biblioteca/notifications',
            'rewrite'     => [
                'slug' => 'notifications',
            ],
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
            'show_in_rest' => false,  // @info inherited from old version
        ),

		'bulletin_board' => array(

            'labels' => array(
                'name'               => __('Bulletin Boards'),
                'singular_name'      => __('Bulletin Board'),
                'menu_name'          => __('Bulletin Boards'),
                'name_admin_bar'     => __('Bulletin Boards'),
                'add_new'            => __('Novo Post'),
                'add_new_item'       => __('Novo Post'),
                'new_item'           => __('Novo Post'),
                'edit_item'          => __('Editar Post'),
                'view_item'          => __('Ver Post'),
                'all_items'          => __('Posts'),
                'search_items'       => __('Procurar por Posts'),
                'parent_item_colon'  => __('Posts pai:'),
                'not_found'          => __('Nenhum Post encontrado.'),
                'not_found_in_trash' => __('Nenhum Post encontrado na lixeira.')
			),
			'menu_position' => 2,
            'menu_icon' => 'dashicons-megaphone',
            'description' => __('Bulletin Boards'),
            'rest_base' =>'custom/bulletin_boards',
            'has_archive' => 'biblioteca/bulletin_boards',
            'rewrite'     => [
            	'slug' => 'bulletin_boards/post',
            ],
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomy'    => array(

                'bulletin_boards_categories' => array(

                    'hierarchical'      => true,
                    'labels'            => array(
                        'name'              => __('Categorias'),
                        'singular_name'     => __('Categoria'),
                        'search_items'      => __('Procurar por categoria' ),
                        'all_items'         => __('Categorias' ),
                        'parent_item'       => __('Categoria Pai' ),
                        'parent_item_colon' => __('Categorias Pai:' ),
                        'edit_item'         => __('Editar Categoria' ),
                        'update_item'       => __('Atualizar Categoria' ),
                        'add_new_item'      => __('Nova Categoria' ),
                        'new_item_name'     => __('Nova Categoria' ),
                        'menu_name'         => __('Categorias' ),
                    ),

                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
					'rewrite'           => array('slug' => 'bulletin_boards/categorias'),
					'show_in_rest'      => true,
                    'rest_base'         => 'bulletin_boards'
                ),
            ),
		),

        'bulletin_board_c' => array(

            'labels' => array(
                'name'               => __('Bulletin Boards Client'),
                'singular_name'      => __('Bulletin Board Client'),
                'menu_name'          => __('Bulletin Boards Client'),
                'name_admin_bar'     => __('Bulletin Boards Client'),
                'add_new'            => __('Novo Post'),
                'add_new_item'       => __('Novo Post'),
                'new_item'           => __('Novo Post'),
                'edit_item'          => __('Editar Post'),
                'view_item'          => __('Ver Post'),
                'all_items'          => __('Posts'),
                'search_items'       => __('Procurar por Posts'),
                'parent_item_colon'  => __('Posts pai:'),
                'not_found'          => __('Nenhum Post encontrado.'),
                'not_found_in_trash' => __('Nenhum Post encontrado na lixeira.')
			),
			'menu_position' => 2,
            'menu_icon' => 'dashicons-megaphone',
            'description' => __('Bulletin Boards Client'),
            'rest_base' =>'custom/bulletin_boards_c',
            'has_archive' => 'biblioteca/bulletin_boards_c',
            'rewrite'     => [
            	'slug' => 'bulletin_boards/post',
            ],
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomy'    => array(

                'bulletin_boards_c_categories' => array(

                    'hierarchical'      => true,
                    'labels'            => array(
                        'name'              => __('Categorias'),
                        'singular_name'     => __('Categoria'),
                        'search_items'      => __('Procurar por categoria' ),
                        'all_items'         => __('Categorias' ),
                        'parent_item'       => __('Categoria Pai' ),
                        'parent_item_colon' => __('Categorias Pai:' ),
                        'edit_item'         => __('Editar Categoria' ),
                        'update_item'       => __('Atualizar Categoria' ),
                        'add_new_item'      => __('Nova Categoria' ),
                        'new_item_name'     => __('Nova Categoria' ),
                        'menu_name'         => __('Categorias' ),
                    ),

                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
					'rewrite'           => array('slug' => 'bulletin_boards_c/categorias'),
					'show_in_rest'      => true,
                    'rest_base'         => 'bulletin_boards_c'
                ),
            ),
		),
    );

    foreach ($posttypes as $posttype => $options) {

        $args = array_merge($def_posttype_args, $options);

        if(isset($args['taxonomy'])){

            $taxonomies = $args['taxonomy'];

            foreach($taxonomies as $taxonomy => $taxonomy_args){

                $taxonomy_args = array_merge($def_taxonomy_args, $taxonomy_args);

                register_taxonomy($taxonomy, array($posttype), $taxonomy_args);

            }

            unset($args['taxonomy']);

        }

        register_post_type($posttype, $args);

    }

}

add_action('init', 'ks_register_post_types', 10 );

/**
 * Change Native Posts labels
 */
function ks_change_post_label() {

    global $menu;
	global $submenu;

    $menu[5][0] = 'Notícias';
    $submenu['edit.php'][5][0] = 'Notícias';
    $submenu['edit.php'][10][0] = 'Adicionar Notícia';

}

// add_action( 'admin_menu', 'ks_change_post_label' );

function ks_change_post_object() {

	global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Notícias';
    $labels->singular_name = 'Notícias';
	$labels->menu_name = 'Notícias';
	$labels->name_admin_bar = 'Notícias';
    $labels->add_new = 'Nova Notícia';
    $labels->add_new_item = 'Nova Notícia';
    $labels->new_item = 'Nova Notícia';
    $labels->edit_item = 'Editar Notícia';
    $labels->view_item = 'Ver Notícia';
    $labels->all_items = 'Notícias';
	$labels->search_items = 'Procurar Notícias';
	$labels->parent_item_colon = 'Notícias pai:';
    $labels->not_found = 'Nenhuma Notícia encontrada';
	$labels->not_found_in_trash = 'Nenhuma Notícia encontrada na lixeira';

}

// add_action( 'init', 'ks_change_post_object' );
