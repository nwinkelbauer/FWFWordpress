<?php get_header(); 
global $post; ?>
<div class="wrap">
<div id="primary" class="content-area">
<div id="video-page">
<h1><?php echo the_title(); ?></h1>
<p class="categories"><?php echo the_category(', '); ?></p>
<hr>

<?php
// $client = get_post_meta($post->ID, "client");
// $date = get_post_meta($post->ID, "date"); 
// $client = $client ? $client[0] : '';
// $date = $date ? $date[0] : '';
$imgid = get_post_meta($post->ID, "url");
if($imgid && $imgid[0]){
    $imgid = $imgid[0];

    $hash = json_decode(file_get_contents("https://vimeo.com/api/oembed.json?url=https://vimeo.com/$imgid/?title=0&title=0&byline=0&portrait=0"));
    echo $hash->html; 
    echo '</br></br>';  
}
echo '<p>' . $post->post_content . '</p>';
?>

</div>
</div>
<?php get_sidebar() ?>
</div>

<?php get_footer(); ?>