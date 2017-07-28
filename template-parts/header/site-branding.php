<?php
/**
 * Displays header site branding
 */

?>
<div class="site-branding">
<?php if ( is_front_page() ) : 
		//get logo;
		global $wp_query;
		$postid = $wp_query->post->ID;
		$logoid = get_post_meta($postid, 'logo-id', true);
		$logo = wp_get_attachment_image_src($logoid, 'full');
		$logo = ( $logo && $logo[0] ) ? $logo[0] : '';
		wp_reset_query();
	?>
	<div class="logo-header"><img src="<?php echo $logo ?>"></img></div>
<?php endif; ?>
	<div class="wrap">
<?php (!is_front_page()) ? the_custom_logo() :''; ?>

		<div class="site-branding-text">
			<?php if ( is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			 <?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>

			<!-- <?php
			$description = get_bloginfo( 'description', 'display' );

			if ( $description || is_customize_preview() ) :
			?>
				<p class="site-description"><?php echo $description; ?></p>
			<?php endif; ?> -->
		</div><!-- .site-branding-text -->

		<?php if ( ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && ! has_nav_menu( 'top' ) ) : ?>
		<a href="#content" class="menu-scroll-down"><?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span></a>
	<?php endif; ?>

	</div><!-- .wrap -->
</div><!-- .site-branding -->
