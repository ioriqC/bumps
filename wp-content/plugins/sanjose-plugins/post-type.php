<?php
/*
 * Portfolio post type.
 */

if( ! class_exists( 'Custom_Post_Type' ) ) {

	class Custom_Post_Type {

		public function __construct() {
			add_action('init', array($this, 'sanjose_register_portfolio'), 0);
			add_action('init', array($this, 'sanjose_register_team'), 0);
		}

		public function sanjose_register_portfolio() {
			$post_type_labels       = array(
				'name'                => 'Portfolios',
				'singular_name'       => 'Portfolio',
				'menu_name'           => 'Portfolio',
				'parent_item_colon'   => 'Parent Item:',
				'all_items'           => 'All Portfolios',
				'view_item'           => 'View Item',
				'add_new_item'        => 'Add New Item',
				'add_new'             => 'Add New',
				'edit_item'           => 'Edit Item',
				'update_item'         => 'Update Item',
				'search_items'        => 'Search portfolios',
				'not_found'           => 'No portfolios found',
				'not_found_in_trash'  => 'No portfolios found in Trash',
			);

			$post_type_rewrite      = array(
				'slug'                => 'portfolio-item',
				'with_front'          => true,
				'pages'               => true,
				'feeds'               => true,
			);

			$post_type_args         = array(
				'label'               => 'portfolio',
				'description'         => 'Portfolio information pages',
				'labels'              => $post_type_labels,
				'supports'            => array( 'editor', 'title', 'thumbnail', 'comments' ),
				'taxonomies'          => array( 'post' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => $post_type_rewrite,
				'capability_type'     => 'post',
			);
			register_post_type( 'portfolio', $post_type_args );

			$taxonomy_labels                = array(
				'name'                        => 'Category',
				'singular_name'               => 'Category',
				'menu_name'                   => 'Categories',
				'all_items'                   => 'All Categories',
				'parent_item'                 => 'Parent Category',
				'parent_item_colon'           => 'Parent Category:',
				'new_item_name'               => 'New Category Name',
				'add_new_item'                => 'Add New Category',
				'edit_item'                   => 'Edit Category',
				'update_item'                 => 'Update Category',
				'separate_items_with_commas'  => 'Separate categories with commas',
				'search_items'                => 'Search categories',
				'add_or_remove_items'         => 'Add or remove categories',
				'choose_from_most_used'       => 'Choose from the most used categories',
			);

			$taxonomy_rewrite         = array(
				'slug'                  => 'portfolio-category',
				'with_front'            => true,
				'hierarchical'          => true,
			);

			$taxonomy_args          = array(
				'labels'              => $taxonomy_labels,
				'hierarchical'        => true,
				'public'              => true,
				'show_ui'             => true,
				'show_admin_column'   => true,
				'show_in_nav_menus'   => true,
				'show_tagcloud'       => true,
				'rewrite'             => $taxonomy_rewrite,
			);
			register_taxonomy( 'portfolio-category', 'portfolio', $taxonomy_args );

			$taxonomy_tags_args     = array(
				'hierarchical'        => false,
				'show_admin_column'   => true,
				'rewrite'             => 'portfolio-tag',
				'label'               => 'Tags',
				'singular_label'      => 'Tags',
			);
			register_taxonomy( 'portfolio-tag', array('portfolio'), $taxonomy_tags_args );

		} //end of register portfolio

        public function sanjose_register_team() {
			$post_type_labels       = array(
				'name'                => 'Teams',
				'singular_name'       => 'Team',
				'menu_name'           => 'Team',
				'parent_item_colon'   => 'Parent Item:',
				'all_items'           => 'All Teams',
				'view_item'           => 'View Item',
				'add_new_item'        => 'Add New Item',
				'add_new'             => 'Add New',
				'edit_item'           => 'Edit Item',
				'update_item'         => 'Update Item',
				'search_items'        => 'Search teams',
				'not_found'           => 'No teams found',
				'not_found_in_trash'  => 'No teams found in Trash',
			);

			$post_type_rewrite      = array(
				'slug'                => 'team-item',
				'with_front'          => true,
				'pages'               => true,
				'feeds'               => true,
			);

			$post_type_args         = array(
				'label'               => 'team',
				'description'         => 'Team information pages',
				'labels'              => $post_type_labels,
				'supports'            => array( 'editor', 'title', 'thumbnail' ),
				'taxonomies'          => array( 'post' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => $post_type_rewrite,
				'capability_type'     => 'post',
                'menu_icon'   		  => 'dashicons-groups'
			);
			register_post_type( 'team', $post_type_args );

            $taxonomy_labels                = array(
                'name'                        => 'Category',
                'singular_name'               => 'Category',
                'menu_name'                   => 'Categories',
                'all_items'                   => 'All Categories',
                'parent_item'                 => 'Parent Category',
                'parent_item_colon'           => 'Parent Category:',
                'new_item_name'               => 'New Category Name',
                'add_new_item'                => 'Add New Category',
                'edit_item'                   => 'Edit Category',
                'update_item'                 => 'Update Category',
                'separate_items_with_commas'  => 'Separate categories with commas',
                'search_items'                => 'Search categories',
                'add_or_remove_items'         => 'Add or remove categories',
                'choose_from_most_used'       => 'Choose from the most used categories',
            );

            $taxonomy_rewrite         = array(
                'slug'                  => 'team-category',
                'with_front'            => true,
                'hierarchical'          => true,
            );

            $taxonomy_args          = array(
                'labels'              => $taxonomy_labels,
                'hierarchical'        => true,
                'public'              => true,
                'show_ui'             => true,
                'show_admin_column'   => true,
                'show_in_nav_menus'   => true,
                'show_tagcloud'       => true,
                'rewrite'             => $taxonomy_rewrite,
            );
            register_taxonomy( 'team-category', 'team', $taxonomy_args );

		} //end of register team

	} // end of class

	new Custom_Post_Type;
} // end of class_exists

