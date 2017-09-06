<?php
header("Access-Control-Allow-Origin: *");

add_action( 'wp_enqueue_scripts', 'fwf_enqueue_styles' );
add_action( 'admin_menu', 'fwf_remove_admin_menus' );
add_action('init', 'fwf_remove_comment_support', 100);
add_action( 'wp_before_admin_bar_render', 'fwf_admin_bar_render' );
add_action( 'admin_menu', 'fwf_change_post_label' );
add_action( 'init', 'fwf_change_post_object' );
add_action('admin_init', 'blog_admin_init');
// add_filter('excerpt_more', 'new_excerpt_more');
// add_filter( 'the_content_more_link', 'modify_read_more_link' );
add_filter( 'twentyseventeen_front_page_sections', 'wpc_custom_front_sections' );
add_action('init', 'add_to_fwf_theme', 100);
add_filter('pre_get_posts', 'query_post_type');
add_action('pre_get_posts', 'filter_category_orderby');

function filter_category_orderby( $query ){
    if( $query->is_category()){
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
        $query->set( 'posts_per_page', -1 );
    }
}


function query_post_type($query) {
    if(is_category() || is_tag()) {
        $post_type = get_query_var('post_type');
        if($post_type) {
            $post_type = $post_type;
        } else {
            $post_type = array('nav_menu_item','post','videos'); // replace CPT to your custom post type
        }
        $query->set('post_type',$post_type);

    }
    return $query;
}

function add_to_fwf_theme() {
    add_theme_support( 'custom-header', array(
      'video' => true
    ));
}

//enqueues style of parent
function fwf_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Removes from admin menu
function fwf_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
    //remove_submenu_page( 'themes.php', 'customize.php' );
    //remove_submenu_page( 'themes.php', 'widgets.php' );
    //remove_submenu_page( 'themes.php', 'header.php' );
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}

// Removes from post and pages
function fwf_remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

// Removes from admin bar
function fwf_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}

function fwf_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'Blog';
    $submenu['edit.php'][10][0] = 'Add Blog Post';
    $submenu['edit.php'][16][0] = 'Tags';
}
function fwf_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Blog';
    $labels->singular_name = 'Blog Post';
    $labels->add_new = 'Add Blog Post';
    $labels->add_new_item = 'Add Blog Post';
    $labels->edit_item = 'Edit Blog Post';
    $labels->new_item = 'Blog Post';
    $labels->view_item = 'View Blog Post';
    $labels->search_items = 'Search Blog Posts';
    $labels->not_found = 'No Blog Posts found';
    $labels->not_found_in_trash = 'No Blog Posts found in Trash';
    $labels->all_items = 'All Blog Posts';
    $labels->menu_name = 'Blog';
    $labels->name_admin_bar = 'Blog';
}

function blog_admin_init() {
	remove_meta_box( 'formatdiv', 'post', 'side' );
	remove_meta_box( 'categorydiv', 'post', 'side' );
	remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
}

// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
    return;
}

function modify_read_more_link() {
    return;
}

/*
 * A simple function to control the number of Twenty Seventeen Theme Front Page Sections
 * Source: wpcolt.com
 */
function wpc_custom_front_sections( $num_sections )
    {
        return 5; //Change this number to change the number of the sections.
    }

    


require( 'setup/class.custom-post-type-videos.php' );
require( 'setup/class.custom-page-templates.php' );
require( 'setup/class.custom-menu-json.php' );
require( 'setup/class.custom-page-media-json.php' );
require( 'setup/class.widget-visibility.php' );

?>