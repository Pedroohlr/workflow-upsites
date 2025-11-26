<?php
function USFormatGallery($string, $attr)
{
  static $instance = 0;
  $instance++;

  $output = '<figure class="block-gallery" id="slick-slider-postimg-' . $instance . '">';
  $arrID = explode(",", $attr['ids']);

  $output .= '<div class="gallery">';
  foreach ($arrID as $imagePost) {
    $output .= '<a fancybox-img data-id="" data-fancybox="gallery_group_' . $instance . '" href="' . wp_get_attachment_image_src($imagePost, 'large')[0] . '"><img src="' . wp_get_attachment_image_src($imagePost, 'large')[0] . '"></a>';
  }
  $output .= '</div>';

  /*$output .= '<div class="pag-gallery">';
  foreach ($posts as $imagePost) {
    $output .= '<img src="' . wp_get_attachment_image_src($imagePost->ID, 'thumbnail')[0] . '">';
  }
  $output .= '</div>';*/

  $output .= '</figure>';

  return $output;
}
add_filter('post_gallery', 'USFormatGallery', 10, 2);
