<?php get_header(); 
global $post; ?>
<div class="wrap">
<div id="primary" class="content-area">
<div id="video-page" class="container">
<h1><?php echo the_title(); ?></h1><hr>

<?php
$client = get_post_meta($post->ID, "client");
$date = get_post_meta($post->ID, "date"); 
$client = $client ? $client[0] : '';
$date = $date ? $date[0] : '';
echo "<small>$client</small></br>";
echo "<small>$date</small>";
$imgid = get_post_meta($post->ID, "url");
if($imgid && $imgid[0]){
    $imgid = $imgid[0];
    $hash = json_decode(file_get_contents("https://vimeo.com/api/oembed.json?url=https://vimeo.com/$imgid&width=650"));
    echo $hash->html;  
}

?>

</div>
</div>
</div>
<?php get_sidebar() ?>
<?php get_footer(); ?>