<?php
/**
 * Template part

 * $args = array(
    * 'grid'   	        => 'grid', class name
    * 'post_type'   	  => 'area-activity',
    * 'posts_per_page'  => 6,
    * 'pagination'  	  => false,
    * 'pagination_type' => 'list', list or button
    * 'template_part'   => 'area-featured', não incluir o 'content-'
    * 'reset_postdata'  => false,
    * 'archive_slug'    => $term, term slug
    * 'archive_tax'     => $tax, taxonomy term
    * 'notthis'         => false, exclui ele mesmo
   * );
   * get_template_part( 'template-parts/inc/inc','posts', $args ); 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

$grid 	 	       = array_key_exists('grid',$args) ? $args['grid'] : 'false';
$post_type 	 	   = array_key_exists('post_type',$args) ? $args['post_type'] : 'post';
$posts_per_page  = array_key_exists('posts_per_page',$args) ? $args['posts_per_page'] : 'false';
$pagination_type = array_key_exists('pagination_type',$args) ? $args['pagination_type'] : 'list';
$pagination 	 	 = array_key_exists('pagination',$args) ? $args['pagination'] : 'false';
$template_part 	 = array_key_exists('template_part',$args) ? $args['template_part'] : 'blog-list';
$reset_postdata  = array_key_exists('reset_postdata',$args) ? $args['reset_postdata'] : 'false';
$archive_slug 	 = array_key_exists('archive_slug',$args) ? $args['archive_slug'] : 'false';
$archive_tax 	 	 = array_key_exists('archive_tax',$args) ? $args['archive_tax'] : 'false';
$notthis 	 	     = array_key_exists('notthis',$args) ? $args['notthis'] : 'false';

$postargs = array(
  'post_type' 						 => $post_type,
  'post_status'            => 'publish',
  'order'                  => 'ASC',
  'orderby'                => 'date',
);
if($posts_per_page != 'false') {
  $postargs['posts_per_page'] = $posts_per_page;
}
if($pagination == 'false') {
  $postargs['no_found_rows'] = true;
  $postargs['update_post_term_cache'] = false;
  $postargs['update_post_meta_cache'] = false;
  $postargs['cache_results'] = false;
} else {
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $postargs['paged'] = $paged;
}
if($archive_slug != 'false') {
  $postargs['tax_query'] = array(
    array(
      'taxonomy' 	=> $archive_tax,
      'field' 		=> 'slug',
      'terms' 		=> $archive_slug,
    )
  );
}
if($notthis != 'false') {
  $postargs['post__not_in'] = array(get_the_ID());
}
$postcat = new WP_Query($postargs);
$maxpages = $postcat->max_num_pages;
$count = 0;
if($grid != 'false') {
  echo '<div class="' . $grid . '">';
}
while ($postcat->have_posts()) : $postcat->the_post();
  $args = array(
    'count' => $count++
  );
  get_template_part('template-parts/posts/content', $template_part, $args);
endwhile;
if($grid != 'false') {
  echo '</div>';
}
if($pagination != 'false' && $pagination_type == 'list' ) {
  echo US_paging_nav($postcat, $paged, $maxpages);
}
if($pagination != 'false' && $pagination_type == 'button' ) {
  echo '<a href="#" id="load-more" data-paged="' . $paged . '" data-maxpages="' . $maxpages . '" data-slug="' . $archive_slug . '" data-tax="' . $archive_tax . '">' . __('carregar mais', 'upsites') . '</a> ';
}
if($reset_postdata != 'true') {
  wp_reset_postdata();
}

?>

