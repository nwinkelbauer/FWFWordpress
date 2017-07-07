<?php

add_action( 'rest_api_init', function() {
    register_rest_field( 'page', 'featured_image_url', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $thumbnail_id = get_post_thumbnail_id( $object->ID );
			return wp_get_attachment_image_src($thumbnail_id, 'full');
        }
    ) );
} );

add_action( 'rest_api_init', function() {
    register_rest_field( 'page', 'page_customs', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $custom = get_post_custom( $object->ID );
			return $custom;
        }
    ) );
} );

add_action( 'rest_api_init', function() {
    register_rest_field( 'page', 'mobile_image_url', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $custom = get_post_custom( $object->ID );
			return wp_get_attachment_image_src($custom['mobile-id'][0], 'full');
        }
    ) );
} );

add_action( 'rest_api_init', function() {
    register_rest_field( 'page', 'logo_image_url', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $custom = get_post_custom( $object->ID );
			return wp_get_attachment_image_src($custom['logo-id'][0], 'full');
        }
    ) );
} );

add_action( 'rest_api_init', function() {
    register_rest_field( 'videos', 'category_slugs', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $slugs = array();
            foreach ($object['categories'] as $cat => $val) {
                $slug = get_category( $val );
                $slugs[$val] = $slug->slug;
            }
            return $slugs;
        }
    ) );
} );

add_action( 'rest_api_init', function() {
    register_rest_field( 'videos', 'video_customs', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $custom = get_post_custom( $object->ID );
            return $custom;
        }
    ) );
} );

add_action( 'rest_api_init', function() {
    register_rest_field( 'videos', 'featured_image_url', array(
        'get_callback' => function( $object, $field_name, $request ) {
            $thumbnail_id = get_post_thumbnail_id( $object->ID );
            return wp_get_attachment_image_src($thumbnail_id, 'medium');
        }
    ) );
} );

?>