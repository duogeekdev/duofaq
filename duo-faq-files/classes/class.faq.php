<?php

if ( ! defined( 'ABSPATH' ) ) wp_die( __( 'Sorry hackers! This is not your place!', 'df' ) );

if( ! class_exists( 'DuoFAQ' ) ) {

    class DuoFAQ extends customPostType{

        private $post_type = array();

        public function __construct() {

            $this->post_type = array(
                'post_type'			 => 'faq',
                'name'               => _x( 'FAQs', 'post type general name', 'df' ),
                'singular_name'      => _x( 'FAQ', 'post type singular name', 'df' ),
                'menu_name'          => _x( 'FAQ', 'admin menu', 'df' ),
                'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar', 'df' ),
                'add_new'            => _x( 'Add New', 'book', 'df' ),
                'add_new_item'       => __( 'Add New Question', 'df' ),
                'new_item'           => __( 'New Question', 'df' ),
                'edit_item'          => __( 'Edit Question', 'df' ),
                'view_item'          => __( 'View Question', 'df' ),
                'all_items'          => __( 'All Questions', 'df' ),
                'search_items'       => __( 'Search Questions', 'df' ),
                'parent_item_colon'  => __( 'Parent Questions:', 'df' ),
                'not_found'          => __( 'No Questions found.', 'df' ),
                'not_found_in_trash' => __( 'No Questions found in Trash.', 'df' ),
                'supports'			 => apply_filters( 'faq_post_type_supports', array( 'title', 'editor', 'author', 'excerpt' ) ),
                'rewrite'			 => apply_filters( 'faq_post_type_rewrite_term', 'faq' )
            );

            parent::__construct( $this->post_type );

            add_action( 'init', array( $this, 'register_faq_post_type' ) );
            add_action( 'init', array( $this, 'register_faq_taxonomies' ) );

            //Adding styles and scripts
            add_action( 'wp_enqueue_scripts', array($this, 'user_faq_styles') );

            //Adding custom columns in taxonomy
            add_action( "manage_edit-faq_categories_columns",          array($this, 'posts_columns_id') );
            add_filter( "manage_edit-faq_categories_sortable_columns", array($this, 'posts_columns_id') );
            add_filter( "manage_faq_categories_custom_column",         array($this, 'posts_custom_id_columns'), 10, 3 );

            add_shortcode( 'duo_faq', array($this, 'faq_shortcode') );

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
                    'tax_name'			=> 'faq_categories',
                    'name'              => _x( 'Categories', 'taxonomy general name', 'df' ),
                    'singular_name'     => _x( 'Category', 'taxonomy singular name', 'df' ),
                    'search_items'      => __( 'Search Categories', 'df' ),
                    'all_items'         => __( 'All Categories', 'df' ),
                    'parent_item'       => __( 'Parent Category', 'df' ),
                    'parent_item_colon' => __( 'Parent Category:', 'df' ),
                    'edit_item'         => __( 'Edit Category', 'df' ),
                    'update_item'       => __( 'Update Category', 'df' ),
                    'add_new_item'      => __( 'Add New Category', 'df' ),
                    'new_item_name'     => __( 'New Category Name', 'df' ),
                    'menu_name'         => __( 'Categories', 'df' ),
                    'rewrite'			=> apply_filters( 'faq_category_cat_rewrite_term', 'faq_categories' ),
                    'hierarchical'		=> true
                )
            );

            foreach( $taxes as $tax ){
                $this->set_tax( $tax );
                $this->register_custom_taxonomies();
            }
        }


        public function user_faq_styles() {
            wp_register_script( 'accordion_js', DF_FILES_URI . '/inc/js/accordion.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion' ) );
            wp_enqueue_script( 'accordion_js' );

            $themes = array( "UI lightness", "UI darkness", "Smoothness", "Start", "Redmond", "Sunny", "Overcast", "Le Frog", "Flick", "Pepper Grinder", "Eggplant", "Dark Hive", "Cupertino", "South Street", "Blitzer", "Humanity", "Hot Sneaks", "Excite Bike", "Vader", "Dot Luv", "Mint Choc", "Black Tie", "Trontastic", "Swanky Purse" );

            // wp_register_style( 'ui_accordion_css', '//code.jquery.com/ui/1.11.2/themes/' . strtolower( str_replace( ' ', '-', $themes[9] ) ) . '/jquery-ui.css' );
            wp_register_style( 'ui_accordion_css', DF_FILES_URI .'/inc/css/asbestos.css' );
            wp_enqueue_style( 'ui_accordion_css' );
            wp_register_style( 'accordion_css', DF_FILES_URI .'/inc/css/faqs.css' );
            wp_enqueue_style( 'accordion_css' );
        }


        /*
         *
         * Adding column in taxonomy
         *
         */
        public function posts_columns_id($columns) {
            return $columns + array ( 'tax_id' => 'ID' );
        }

        public function posts_custom_id_columns($v, $name, $id) {
            return $id;
        }


        public function faq_shortcode( $atts ){
            extract( shortcode_atts( array(
                'category' => ''
            ), $atts ) );

            $html = '';

            if($category != '')
            {
                $cat = get_term( $category, 'faq_categories' );
                include DF_FILES_DIR . '/templates/category_view.php';
            }
            else
            {
                $cat = get_terms('faq_categories');
                include DF_FILES_DIR . '/templates/all_view.php';
            }

            return $html;
        }

    }

    new DuoFAQ();

}