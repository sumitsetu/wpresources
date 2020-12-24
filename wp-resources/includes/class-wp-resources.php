<?php
class WP_Resources{

    private $metabox_loader;

    public function __construct() {
		activate_plugin_name();
        add_action( 'init', array( $this,'wp_resources_init') );
        $this->func_loader_run();
        //add_action( 'add_meta_boxes', array( $this, 'wp_register_meta_box') );
    }

	/** 
     * Create custom post type
    */
    public function wp_resources_init(){
        $labels = array(
            'name'                  => _x( 'WP Resources Show', 'Post type for generating shortcodes', 'wpresources' ),
			'singular_name'         => _x( 'wp Resource', 'Post type for generating shortcodes', 'wpresources' ),
			'menu_name'             => _x( 'WP Resources', 'Admin Menu text', 'wpresources' ),
			'all_items'             => _X( 'All Resources', 'wpresources' ),
			'add_new_item'          => __( 'Add WP Resources', 'wpresources' ),
            );     
        $args = array(
            'labels'             => $labels,
            'description'        => 'WP Resources post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'menu_icon'          => 'dashicons-screenoptions',
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'wp-resources' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array( 'title'),
            'taxonomies'         => array( 'category',),
            'show_in_rest'       => true
        );
          
        register_post_type( 'wp-resources', $args );
	}

    public function func_loader_run(){
        require_once plugin_dir_path( __FILE__ ) . '/Wpresources_Post_Type_Metaboxes.php';
        $this->metabox_loader = new Wpresources_Post_Type_Metaboxes();
    }
    public function run(){
        $this->metabox_loader->create_metaboxes();
    }
}