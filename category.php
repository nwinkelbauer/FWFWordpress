<?php get_header(); ?>
<div id="video-archive" class="container">
<h1><?php echo single_cat_title( '', false ); ?></h1><hr>

<?php
if ( have_posts() ) : 
    while ( have_posts() ) : the_post();
    $image = get_the_post_thumbnail_url($post->ID, 'large' ); 
    $title = get_the_title();
    $link = get_the_permalink();
    $client = get_post_meta($post->ID, "client");
    $date = get_post_meta($post->ID, "date"); 
    $image = $image ? $image : '';
    $client = $client ? $client[0] : '';
    $date = $date ? $date[0] : '';
	?>
		<div class="video col-md-4">
            <a href="<?php echo $link; ?>">
            <div style="background-image: url(<?php echo $image; ?>);" class="videoThumbnail"></div>
            <div class="video-info">
                <div>
                    <small><?php echo $client; ?></small><!-- client -->
                    <h3><?php echo $title; ?></h3><!-- title -->
                    <small><?php echo $date; ?></small><!-- date -->
                </div>
            </div>
            </a>
        </div>

	<?php
	endwhile; 
endif; 
?>

</div>

<?php get_footer(); ?>