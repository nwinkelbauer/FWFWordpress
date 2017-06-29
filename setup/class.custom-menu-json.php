<?php
flush_rewrite_rules();
add_action( 'init', 'fwf_add_endpoint' );
add_filter('template_include', 'fwf_include_print_template');


//writes menus into json at /json-menus/
function fwf_add_endpoint() {
    add_rewrite_endpoint('json-menus', EP_ROOT);
}

function fwf_include_print_template( $template ) {
    get_query_var('json-menus');
    if (false === get_query_var('json-menus', false)) {
        return $template;
    }

    // Don't worry about this yet, we'll write this function in step #3
    $menus = fwf_get_menu_json_array();

    wp_send_json( array(
        'menus' => $menus
    ));
}

function fwf_get_menu_json_array() {
	$menulist = get_terms('nav_menu'); //wp_get_nav_menu_items($menu);
	$menus = array();
	//return wp_get_nav_menu_items('menu');
	foreach($menulist as $menu){
		$menuPages = wp_get_nav_menu_items($menu);
		$pages = array();
		foreach($menuPages as $page){
			if($page->menu_item_parent === "0"){
				$pageInfo = array();
				$post_id = get_post_meta( $page->ID, '_menu_item_object_id', true );
				$post = get_post($post_id);

				$pageInfo['id'] = $post_id;
				$pageInfo['menu_order'] = $page->menu_order;
				//$pageInfo['menu_item_parent'] = $page->menu_item_parent;
				$pageInfo['title'] = $post->post_title;
				$pageInfo['slug'] = $post->post_name;
				$pageInfo['children'] = get_nav_menu_item_children($page->ID, $menuPages);
				$pages[$pageInfo['slug']] = $pageInfo;
			}
		}
		$pages["slug"] = $menu->slug;
		$menus[$menu->slug] = $pages;
	}
    return $menus;
}


/**
* Returns all child nav_menu_items under a specific parent
*
* @param int the parent nav_menu_item ID
* @param array nav_menu_items
* @return array returns filtered array of nav_menu_items
*/
function get_nav_menu_item_children( $parent_id, $nav_menu_items ) {
	$pages = array();
	foreach ( (array) $nav_menu_items as $page ) {
		if ( $page->menu_item_parent == $parent_id ) {
			//$nav_menu_item_list[] = $nav_menu_item;
			$pageInfo = array();
			$post_id = get_post_meta( $page->ID, '_menu_item_object_id', true );
			$post = get_post($post_id);

			$pageInfo['id'] = $post_id;
			$pageInfo['menu_order'] = $page->menu_order;
			//$pageInfo['menu_item_parent'] = $page->menu_item_parent;
			$pageInfo['title'] = $post->post_title;
			$pageInfo['slug'] = $post->post_name;
			$pages[$pageInfo['slug']] = $pageInfo;
		}
	}
	return $pages;
	}


?>