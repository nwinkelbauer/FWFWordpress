<?php

add_action( 'add_meta_boxes_page', 'fwf_add_meta_boxes_page' );
add_action( 'admin_enqueue_scripts', 'fwf_admin_script_enqueuer' );

function fwf_add_meta_boxes_page() {
    global $post;
    if ( 'templates/page_portfolio.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
        add_meta_box( 'category', 'Category', 'fwf_category_meta_box_callback', 'page', 'normal', 'high' );
    }
    if ( 'templates/page_about.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
        add_meta_box( 'contact', 'Contact Info', 'fwf_contact_meta_box_callback', 'page', 'normal', 'low' );
    }
    if ( 'templates/page_home.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
        add_meta_box( 'logo', 'Logo (PNG)', 'fwf_logo_meta_box_callback', 'page', 'side', 'default' );
    }
    add_meta_box( 'video', 'Vimeo Background ID (optional)', 'fwf_video_meta_box_callback', 'page', 'side', 'default' );
    add_meta_box( 'mobile', 'Mobile Background (optional)', 'fwf_mobile_meta_box_callback', 'page', 'side', 'low' );
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

function fwf_contact_meta_box_callback() {
	global $post;
	$custom = get_post_custom($post->ID);
	$contact_phone = $custom['contact-phone'][0];
	$contact_email = $custom['contact-email'][0];
	?>	Phone:<input name="contact-phone" value="<?php echo $contact_phone ?>" /> </br>
		Email:<input name="contact-email" value="<?php echo $contact_email ?>" /><?php
}

function fwf_video_meta_box_callback() {
	global $post;
	$custom = get_post_custom($post->ID);
	$video = $custom['video'][0];
	?><input name="video" value="<?php echo $video ?>" /><?php
}

function fwf_mobile_meta_box_callback() {
	wp_register_script( 'meta-box-mobile_js', get_stylesheet_directory_uri() . '/setup/js/meta-box-mobile.js', false, '1.0.0' );
    wp_enqueue_script( 'meta-box-mobile_js' );

	global $post;

	// Get WordPress' media upload URL
	$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

	// See if there's a media id already saved as post meta
	$mobile_id = get_post_meta( $post->ID, 'mobile-id', true );

	// Get the image src
	$mobile_src = wp_get_attachment_image_src( $mobile_id, 'full' );

	// For convenience, see if the array is valid
	$mobile_img = is_array( $mobile_src );
	?>

	<!-- Your image container, which can be manipulated with js -->
	<div class="mobile-container">
	    <?php if ( $mobile_img ) : ?>
	        <img src="<?php echo $mobile_src[0] ?>" alt="" style="max-width:100%;" />
	    <?php endif; ?>
	</div>

	<!-- Your add & remove image links -->
	<p class="hide-if-no-js">
	    <a class="upload-mobile <?php if ( $mobile_img  ) { echo 'hidden'; } ?>" 
	       href="<?php echo $upload_link ?>">
	        <?php _e('Set mobile image') ?>
	    </a>
	    <a class="delete-mobile <?php if ( ! $mobile_img  ) { echo 'hidden'; } ?>" 
	      href="#">
	        <?php _e('Remove mobile image') ?>
	    </a>
	</p>

	<!-- A hidden input to set and post the chosen image id -->
	<input class="mobile-id" name="mobile-id" type="hidden" value="<?php echo esc_attr( $mobile_id ); ?>" /> <?php
}

function fwf_logo_meta_box_callback() {
	wp_register_script( 'meta-box-logo_js', get_stylesheet_directory_uri() . '/setup/js/meta-box-logo.js', false, '1.0.0' );
    wp_enqueue_script( 'meta-box-logo_js' );

	global $post;

	// Get WordPress' media upload URL
	$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

	// See if there's a media id already saved as post meta
	$logo_id = get_post_meta( $post->ID, 'logo-id', true );

	// Get the image src
	$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );

	// For convenience, see if the array is valid
	$logo_img = is_array( $logo_src );
	?>

	<!-- Your image container, which can be manipulated with js -->
	<div class="logo-container">
	    <?php if ( $logo_img ) : ?>
	        <img src="<?php echo $logo_src[0] ?>" alt="" style="max-width:100%;" />
	    <?php endif; ?>
	</div>

	<!-- Your add & remove image links -->
	<p class="hide-if-no-js">
	    <a class="upload-logo <?php if ( $logo_img  ) { echo 'hidden'; } ?>" 
	       href="<?php echo $upload_link ?>">
	        <?php _e('Set logo image') ?>
	    </a>
	    <a class="delete-logo <?php if ( ! $logo_img  ) { echo 'hidden'; } ?>" 
	      href="#">
	        <?php _e('Remove logo') ?>
	    </a>
	</p>

	<!-- A hidden input to set and post the chosen image id -->
	<input class="logo-id" name="logo-id" type="hidden" value="<?php echo esc_attr( $logo_id ); ?>" /> <?php
}

add_action('save_post', 'fwf_save_meta_box_page_details');
function fwf_save_meta_box_page_details() {
	global $post;
	if (get_post_type($post) == 'page') {
		update_post_meta($post->ID, 'category', $_POST['category']);
		update_post_meta($post->ID, 'contact-phone', $_POST['contact-phone']);
		update_post_meta($post->ID, 'contact-email', $_POST['contact-email']);
		update_post_meta($post->ID, 'video', $_POST['video']);
		update_post_meta($post->ID, 'mobile-id', $_POST['mobile-id']);
		update_post_meta($post->ID, 'logo-id', $_POST['logo-id']);
	}
}


?>
