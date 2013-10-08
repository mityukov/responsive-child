<?php

function random_picture($atts) {
   extract(shortcode_atts(array(
      'width' => 400,
      'height' => 200,
   ), $atts));
   return '<img src="http://lorempixel.com/'. $width . '/'. $height . '" />';
}

function simplest_store() {
	
	$raw_json = file(ABSPATH . 'wp-content/plugins/alpine-photo-tile-for-flickr/cache/flickr-1-2-5-user-100551192@N08-groupid-set-tags-30-off-link-Flickr-500.cache');

	$raw_json = join("\n",$raw_json);
	$photos = unserialize($raw_json);
	
	ob_start();
	foreach ($photos['photos'] as $phk => $photo) {
?>
<div class="grid col-300<?php if (($phk+1)%3==0) echo " fit"; ?>">
  <div class="jm-image-wrapper" style="background-image: url(<?=$photo['image_source']; ?>);">
    <a href="<?=$photo['image_original']; ?>" title="<?=$photo['image_title']?>" alt="<?=$photo['image_caption']?>">
      <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" title="<?=$photo['image_title']?>" alt="<?=$photo['image_title']?>" width="294" height="182" border="0">
    </a>
  </div>
  <div class="jm-text-wrapper"><a class="button thickbox" href="#TB_inline?inlineId=buy-form" onclick="javascript: document.getElementsByClassName('wpcf7-textarea')[0].value='Описание товара: <?=htmlspecialchars($photo['image_caption']);?>';">Купить</a></div>
</div>
<?php
	}
	return ob_get_clean();
}

add_shortcode('random_picture', 'random_picture');
add_shortcode('simplest_store', 'simplest_store');

 

/**
 * Proper way to enqueue scripts and styles
 */
function jm_thickbox_styles() {

	wp_register_style('thickbox_overwrite', get_stylesheet_directory_uri().'/core/css/thickbox.css', array('thickbox'));
	wp_enqueue_style('thickbox_overwrite');
}
add_action( 'wp_enqueue_scripts', 'jm_thickbox_styles' );


?>
