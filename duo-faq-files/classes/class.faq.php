<?php

if ( ! defined( 'ABSPATH' ) ) wp_die( __( 'Sorry hackers! This is not your place!', 'df' ) );

if( ! class_exists( 'DuoFAQ' ) ) {

    class DuoFAQ extends customPostType{

        private $post_type = array();

        public function __construct() {

            $this->post_type = array(
                'post_type'			 => 'faq',
                'name'               => _x( 'FAQs', 'post type general name', 'sn' ),
                'singular_name'      => _x( 'FAQ', 'post type singular name', 'sn' ),
                'menu_name'          => _x( 'FAQ', 'admin menu', 'sn' ),
                'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar', 'sn' ),
                'add_new'            => _x( 'Add New', 'book', 'sn' ),
                'add_new_item'       => __( 'Add New Question', 'sn' ),
                'new_item'           => __( 'New Question', 'sn' ),
                'edit_item'          => __( 'Edit Question', 'sn' ),
                'view_item'          => __( 'View Question', 'sn' ),
                'all_items'          => __( 'All Questions', 'sn' ),
                'search_items'       => __( 'Search Questions', 'sn' ),
                'parent_item_colon'  => __( 'Parent Questions:', 'sn' ),
                'not_found'          => __( 'No Questions found.', 'sn' ),
                'not_found_in_trash' => __( 'No Questions found in Trash.', 'sn' ),
                'supports'			 => apply_filters( 'faq_post_type_supports', array( 'title', 'editor', 'author', 'excerpt' ) ),
                'rewrite'			 => apply_filters( 'faq_post_type_rewrite_term', 'faq' )
            );

            parent::__construct( $this->post_type );

            add_action( 'init', array( $this, 'register_faq_post_type' ) );
            add_action( 'init', array( $this, 'register_faq_taxonomies' ) );

        }

        /*
		 * Calling register function from parent class
		 */
        public function register_faq_post_type() {
            $this->register_custom_post_type();
        }

        /*
		 * Calling register taxonomy function from parent class
		 */
        public function register_faq_taxonomies() {
            $taxes = array(
                array(
                    'tax_name'			=> 'faq_category',
                    'name'              => _x( 'Categories', 'taxonomy general name' ),
                    'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
                    'search_items'      => __( 'Search Categories' ),
                    'all_items'         => __( 'All Categories' ),
                    'parent_item'       => __( 'Parent Category' ),
                    'parent_item_colon' => __( 'Parent Category:' ),
                    'edit_item'         => __( 'Edit Category' ),
                    'update_item'       => __( 'Update Category' ),
                    'add_new_item'      => __( 'Add New Category' ),
                    'new_item_name'     => __( 'New Category Name' ),
                    'menu_name'         => __( 'Categories' ),
                    'rewrite'			=> apply_filters( 'faq_category_cat_rewrite_term', 'kb_category' ),
                    'hierarchical'		=> true
                )
            );

            foreach( $taxes as $tax ){
                $this->set_tax( $tax );
                $this->register_custom_taxonomies();
            }
        }

    }

    new DuoFAQ();

}