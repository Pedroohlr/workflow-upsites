<?php
function US_set_post_views($postID)
{
  $count_key = 'US_post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    $count = 0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
  } else {
    $count++;
    update_post_meta($postID, $count_key, $count);
  }
}
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function US_post_views_count($column)
{
  $column['US_post_views_count'] = _e('Visualizações', 'upsites');
  return $column;
}
add_filter('manage_posts_columns', 'US_post_views_count');
function views_count_show_columns($name)
{
  global $post;
  switch ($name) {
    case 'US_post_views_count':
      $views = get_post_meta($post->ID, 'US_post_views_count', true);
      echo $views;
  }
}
add_action('manage_posts_custom_column',  'views_count_show_columns');
