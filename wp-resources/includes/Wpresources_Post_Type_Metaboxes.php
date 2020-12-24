<?php

/**
* load metaboxes for wp resource plugin
*/
class Wpresources_Post_Type_Metaboxes {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array($this, 'wp_resources_scripts' ));
		add_action('admin_init', array( $this, 'wpresources_custom_shortcode_load') );
		$this->wpresource_ajax_call();
	}

	/**
    * function that activates the metabox
	*/
	public function create_metaboxes() {
		add_action( 'add_meta_boxes', array( $this, 'wpresources_meta_boxes' ) );
		add_action( 'add_meta_boxes', array( $this, 'hide_categories_metabox' ) );
		add_action( 'save_post', array( $this, 'save_wpresources_meta_boxes' ),10,2 );
		add_action( 'add_meta_boxes', array( $this, 'wpresources_auto_shortcode' ) );
		add_filter( 'manage_wp-resources_posts_columns', array( $this, 'set_wpresources_shortcodes_columns') );
	}

	/**
    * function for removing category section from side
	*/
	public function hide_categories_metabox() {
		remove_meta_box('categorydiv','wp-resources','side');
	}

	/**
	 * Register the metaboxes to be used for the Wp Resource post type
	 *
	 * @since 0.1.0
	 */
	public function wpresources_meta_boxes() {
		add_meta_box(
			'add_blogs_wpresources',
			'Add Blogs',
			array( $this, 'render_wpresource_meta_boxes' ),
			'wp-resources',
			'normal',
			'default'
		);
	}

       /**
	* The HTML for the fields
	*
	* @since 0.1.0
	*/
	function render_wpresource_meta_boxes( $post ) {
		global $post;
		$meta = get_post_custom( $post->ID );
		$title = ! isset( $meta['blog_title'][0] ) ? '' : $meta['blog_title'][0];

		wp_nonce_field( 'add_blogs_wpresources_action', 'add_blogs_wpresources' ); 

		
		if ($post->post_type == 'wp-resources') {
	
			$tabs = [
				'Add Blogs',
				'Add eBooks',
				'Add Case Studies'
			];

			?>
			<div class="wpresource-my-container">
				<div class="wpresource-content-wrap">
					<div class="wpresource-tab-group-left">
						<nav class="wpresource-tab-list">
							<ul>
								<?php foreach($tabs as $tab){
									$small_cap_tabs = strtolower($tab);
									$data = preg_replace('/\s+/', '', $small_cap_tabs);
									echo "<li id='".strtolower($data)."'><a href='#'>".$tab."</a></li>";
								} ?>
							</ul>
						</nav>
					</div>
					<?php 
						if(!empty($meta['wpresourcemetadata'])){
							$wpresource_unserialized_data = $meta['wpresourcemetadata'];
							foreach($wpresource_unserialized_data as $result) {
								$get_serialized_value = unserialize($result);
							}
						}
					?>
					<div class="wpresource-tab-group-right">
						<div id="wpresource-tab-input-blogs" class="wpresource-tab-input-blogs">
							<div class="wpresource-blog-label"><label for="blog_count"><b><?php _e( 'Number of Blogs', 'wpresources' ); ?></b></label></div>
							<div class="wpresource-input-data"><input type="number" name="blog_count" id="blog_count"  class="wpresource_input_count regular-text" min="0" max="10" value="<?php if(!empty($get_serialized_value['wpresource_blogs']))echo count($get_serialized_value['wpresource_blogs']); ?>"></div>
							<?php 
							if(!empty($get_serialized_value)){
								foreach($get_serialized_value as $ind => $value){
									$get_wpresource_tab_name = $ind;
									$count_num_wpresources = count($value);
									if( "wpresource_blogs" === $get_wpresource_tab_name && $count_num_wpresources > 0){						
										foreach($value as $ind1 => $new_value){
											$wpresources_blogs_query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish',
										'post__not_in' => array($new_value) ) );
											$output = '<div class="wpresource-input-data"><select name="wpresource-blogs[]" id="wpresource-select-blogs" class="wpresource_input_count regular-text">';
											$output .= '<option value="' . $new_value . '" selected>' . get_the_title($new_value) . '</option>';
											while ( $wpresources_blogs_query->have_posts() ) {
												$wpresources_blogs_query->the_post();
												$output .= '<option value="' . $wpresources_blogs_query->post->ID . '">' . get_the_title() . '</option>';
											}
											$output .= '</select><span data-tab="wpresource_blogs"></span></div>';
											echo $output;
										}
									}
								}
							}
							?>
						</div>
						<div id="wpresource-tab-input-ebooks" class="wpresource-tab-input-ebooks">
							<div class="wpresource-blog-label"><label for="ebook_count"><b><?php _e( 'Number of eBooks', 'wpresources' ); ?></b></label></div>
							<div class="wpresource-input-data"><input type="number" name="ebook_count" id="ebook_count"  class="wpresource_input_count regular-text" min="0" max="10" value="<?php if(!empty($get_serialized_value['wpresource_ebooks'])) echo count($get_serialized_value['wpresource_ebooks']); ?>"></div>
							<?php 
							if(!empty($get_serialized_value)){
								foreach($get_serialized_value as $ind => $value){
									$get_wpresource_tab_name = $ind;
									$count_num_wpresources = count($value);
									if( "wpresource_ebooks" === $get_wpresource_tab_name && $count_num_wpresources > 0){
										foreach($value as $ind1 => $new_value){
											$wpresources_ebooks_query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish',
										'post__not_in' => array($new_value) ) );
											$output = '<div class="wpresource-input-data"><select name="wpresource-ebooks[]" id="wpresource-select-blogs" class="wpresource_input_count regular-text">';
											$output .= '<option value="' . $new_value . '" selected>' . get_the_title($new_value) . '</option>';
											while ( $wpresources_ebooks_query->have_posts() ) {
												$wpresources_ebooks_query->the_post();
												$output .= '<option value="' . $wpresources_ebooks_query->post->ID . '">' . get_the_title() . '</option>';
											}
											$output .= '</select><span></span></div>';
											echo $output;
										}
									}
								}
							}
							?>
						</div>
						<div id="wpresource-tab-input-casestudies" class="wpresource-tab-input-casestudies">
							<div class="wpresource-blog-label"><label for="casestudy_count"><b><?php _e( 'Number of Case Studies', 'wpresources' ); ?></b></label></div>
							<div class="wpresource-input-data"><input type="number" name="casestudy_count" id="casestudy_count"  class="wpresource_input_count regular-text" min="0" max="10" value="<?php if(!empty($get_serialized_value['wpresource_casestudies'])) echo count($get_serialized_value['wpresource_casestudies']); ?>"></div>
							<?php 
							if(!empty($get_serialized_value)){
								foreach($get_serialized_value as $ind => $value){
									$get_wpresource_tab_name = $ind;
									$count_num_wpresources = count($value);
									if( "wpresource_casestudies" === $get_wpresource_tab_name && $count_num_wpresources > 0){
										foreach($value as $ind1 => $new_value){
											$wpresources_case_query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish',
										'post__not_in' => array($new_value) ) );
											$output = '<div class="wpresource-input-data"><select name="wpresource-casestudies[]" id="wpresource-select-blogs" class="wpresource_input_count regular-text">';
											$output .= '<option value="' . $new_value . '" selected>' . get_the_title($new_value) . '</option>';
											while ( $wpresources_case_query->have_posts() ) {
												$wpresources_case_query->the_post();
												$output .= '<option value="' . $wpresources_case_query->post->ID . '">' . get_the_title() . '</option>';
											}
											$output .= '</select><span></span></div>';
											echo $output;
										}
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>

		<?php }
	}

	public function wp_resources_scripts(){
		wp_enqueue_style('wp-resources-style',  plugins_url( '/assets/css/wpresources.css', __DIR__ ) , array(), '1.0');
		wp_register_script('wp-resources-js',  plugins_url( '/assets/js/wpresources.js', __DIR__ ), array('jquery'), '1.0', true);
		wp_enqueue_script( 'wpresource-render-script', plugins_url( '/assets/js/wpresource-render-data.js', __DIR__ ), array('jquery'), '1.0', true );
		wp_enqueue_script ('wp-resources-js');
		// wp_localize_script( 'wpresource-render-script', 'wpresource_ajax_object',
		// 	array( 
		// 		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		// 		'nonce' => wp_create_nonce( 'wp_resource' ),
		// 		'ajaxurl' => admin_url('admin-ajax.php')
		// 		)
    	// );
	}

	/**
    * function that calls ajax
	*/
	public function wpresource_ajax_call() {
		require_once plugin_dir_path( __FILE__ ) . '/Wpresources_input_post_data.php';
		$wpresource_ajax_data = new Wpresources_input_post_data();
	}

	/**
	 * save custom post type
	*/
	function save_wpresources_meta_boxes($post_id,$post) {
	
		if( !isset( $_POST['add_blogs_wpresources'] ) || !wp_verify_nonce( $_POST['add_blogs_wpresources'],'add_blogs_wpresources_action') ) 
			return;
	
		if ( !current_user_can( 'edit_post', $post_id ))
			return;
	
		$wpresource_meta = array();
		
		//Add values to custom fields
		if(isset($_POST['wpresource-blogs'])){
			while (($pos = array_search(-1, $_POST['wpresource-blogs'])) !== FALSE) {
				unset($_POST['wpresource-blogs'][$pos]);
			  }
			$wpresource_meta['wpresource_blogs'] = array_values($_POST['wpresource-blogs']);
		}
		if(isset($_POST['wpresource-ebooks'])){
			while (($pos = array_search(-1, $_POST['wpresource-ebooks'])) !== FALSE) {
				unset($_POST['wpresource-ebooks'][$pos]);
			}
			$wpresource_meta['wpresource_ebooks'] = $_POST['wpresource-ebooks'];
		}
		if(isset($_POST['wpresource-casestudies'])){
			while (($pos = array_search(-1, $_POST['wpresource-casestudies'])) !== FALSE) {
				unset($_POST['wpresource-casestudies'][$pos]);
			}
			$wpresource_meta['wpresource_casestudies'] = $_POST['wpresource-casestudies'];
		}
		$key = 'wpresourcemetadata';
		if ($post->post_type == "revision")
         return;
		if (get_post_meta($post_id, $key, FALSE)) {
			update_post_meta($post_id, $key, $wpresource_meta);
		}
		else {
			add_post_meta($post_id, $key, $wpresource_meta);
		}
		if (!$wpresource_meta) {
			delete_post_meta($post_id, $key);
		}
	}

	/**
	 * generate shortcode for wp resource automatically
	*/
	public function wpresources_auto_shortcode()
	{
		add_meta_box(
			'add_wpresources_shortcodes',
			'Usage',
			array( $this, 'render_wpresource_shortcodes' ),
			'wp-resources',
			'side',
			'default'
		);
	}

	public function render_wpresource_shortcodes($post){
		global $post;
		$disable_text_field = true;
		?>
		<div><label for="wpresource-shortcode"><b>Shortcode</b></label></div>
		<div>
			<input type="text" <?php readonly( $disable_text_field, true ); ?> name="wpresource-shortcode"  
			class="wpresource-shortcode-input" value='[wpresources title="<?php echo get_the_title($post->ID);?>" id=<?php echo $post->ID; ?>]' />
		</div>
		<?php
	}

	/**
	 * Add admin column shortcode in wpresource
	*/
	public function set_wpresources_shortcodes_columns($columns){	
		unset($columns['date']);
		$columns['wpresources_shortcodes'] = __( 'Shortcode', 'wpresources' );
		$columns['date'] = __('Date');
    	return $columns;
	}

	public function wpresources_custom_shortcode_load(){
		add_action( 'manage_wp-resources_posts_custom_column' , array($this, 'custom_wpresource_codes_column'), 10, 2 );
	}

	public function custom_wpresource_codes_column($column, $post_id ){
		if($column == "wpresources_shortcodes"){
			echo '[wpresources title="'. get_the_title($post_id). '" id='. $post_id .']';
		
		}
	}
}
