<?php

add_action( 'add_meta_boxes_page', 'fwf_add_meta_boxes_page' );
add_action( 'admin_enqueue_scripts', 'fwf_admin_script_enqueuer' );

function fwf_add_meta_boxes_page() {
    global $post;
    if ( 'templates/page_portfolio.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
        add_meta_box( 'category', 'Category', 'fwf_category_meta_box_callback', 'page', 'normal', 'high' );
        add_action('save_post', 'fwf_save_meta_box_page_details');
    }
}

/*Change Meta Box visibility according to Page Template*/
function fwf_admin_script_enqueuer() {
    global $current_screen;
    if('page' != $current_screen->id) return;

    wp_register_script( 'meta-box-visibility_js', get_stylesheet_directory_uri() . '/setup/js/meta-box-visibility.js', false, '1.0.0' );
    wp_enqueue_script( 'meta-box-visibility_js' );
}

function fwf_category_meta_box_callback() {
	global $post;
	$custom = get_post_custom($post->ID);
	$category = $custom['category'][0];
	?><!-- <input name="category" value="<?php //echo $category ?>" /> --><?php
	wp_dropdown_categories( array(
	    'show_option_all'    => 'Choose a category',
	    'show_count'         => 0,
	    'hide_empty'         => 0, 
	    'child_of'           => 0,
	    'exclude'            => '',
	    'echo'               => 1,
	    'selected'           => $category,
	    'hierarchical'       => 1, 
	    'name'               => 'category',     // important
	    'id'                 => $post->ID,
	    'class'              => 'form-no-clear',
	    'depth'              => 0,
	    'tab_index'          => 0,
	    'taxonomy'           => 'category',
	    'hide_if_empty'      => true
	) );
}

function fwf_save_meta_box_page_details() {
		global $post;
		if (get_post_type($post) == 'page') {
			update_post_meta($post->ID, 'category', $_POST['category']);
		}
	}

?>
