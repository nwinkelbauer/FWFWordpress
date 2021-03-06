<?php 

if ( ! post_type_exists( 'videos' ) ):

	add_action('init', 'video_post_type');

	function video_post_type() {
		$labels = array(
			'name' => 'Videos',
			'singular_name' => 'Video',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Video',
			'edit_item' => 'Edit Video',
			'new_item' => 'New Video',
			'all_items' => 'All Videos',
			'view_item' => 'View Video',
			'search_item' => 'Search Videos',
			'not_found' => 'No videos found',
			'not_found_in_trash' => 'No videos found in trash',
			'parent_item_colon' => '',
			'menu_name' => 'Videos'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			//'hierarchical' => true,
			'taxonomies' => array('category'), //'post_tag' for tags
			'rewrite' => array('slug' => 'portfolio'),
			'has_archive' => true,
			'show_in_rest' => true,
    		'rest_base' => 'videos',
    		'rest_controller_class' => 'WP_REST_Posts_Controller',
			'supports' => array( 'title' , 'editor' , 'thumbnail', 'page-attributes' )
		);

		register_post_type('videos', $args);

		if (!term_exists( 'Commercial', 'category') ){
	        wp_insert_term( 'Commercial', 'category' );
	    }
		if (!term_exists( 'Television', 'category') ){
	        wp_insert_term( 'Television', 'category' );
	    }
		if (!term_exists( 'Philanthropy', 'category') ){
	        wp_insert_term( 'Philanthropy', 'category' );
	    }
	}

	add_action('admin_init', 'video_admin_init');

	function video_admin_init(){
		add_meta_box( 'order', 'Order', 'order_callback', 'videos', 'side', 'default' );
		add_meta_box( 'url', 'Vimeo ID Code', 'url_callback', 'videos', 'side', 'default' );
		add_meta_box( 'date', 'Year Created', 'date_callback', 'videos', 'side', 'default' );
		add_meta_box( 'client', 'Client', 'client_callback', 'videos', 'side', 'default' );

		remove_meta_box( 'categorydiv', 'videos', 'side' );
		add_meta_box( 'categorydiv', 'Category', 'post_categories_meta_box', 'videos', 'normal', 'low', array( 'taxonomy' => 'category' ) );
		
		add_action('save_post', 'save_video_details');
	}

	function url_callback() {
		global $post;
		$custom = get_post_custom($post->ID);
		$url = $custom['url'][0];
		?><input name="url" value="<?php echo $url ?>" /><?php
	}

	function date_callback() {
		global $post;
		$custom = get_post_custom($post->ID);
		$date = $custom['date'][0];
		?><input name="date" value="<?php echo $date ?>" /><?php
	}

	function client_callback() {
		global $post;
		$custom = get_post_custom($post->ID);
		$client = $custom['client'][0];
		?><input name="client" value="<?php echo $client ?>" /><?php
	}

	function order_callback() {
		global $post;
		// $custom = get_post_custom($post->ID);
		// $order = $custom['order'][0];
		?><!-- <input name="order" value="<?php echo $order ?>" /> </br> -->
		<small>Order starts at 1. Ties are sorted by date. For those you want unordered at the bottom, just set order to 100. </br></br>If you want to remove video from showing up, set status to draft or visibility to private.</small> <?php
	}

	function save_video_details() {
		global $post;
		if (get_post_type($post) == 'videos') {
			update_post_meta($post->ID, 'url', $_POST['url']);
			update_post_meta($post->ID, 'date', $_POST['date']);
			update_post_meta($post->ID, 'client', $_POST['client']);
			//update_post_meta($post->ID, 'order', $_POST['order']);
		}
	}

	
endif;

?>
