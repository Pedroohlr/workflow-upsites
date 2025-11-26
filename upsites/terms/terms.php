<?php

function US_term_list($ID, $cat, $type) {
  //echo $cat;
  $term_list = wp_get_post_terms($ID, $cat, ['fields' => 'all']);
  $primary_term_bkp = $term_list[0]->name;
  $primary_termid_bkp = $term_list[0]->term_id;
  $primary_term = '';
  $primary_termid = '';

  foreach ($term_list as $term) {
    if (get_post_meta($ID, '_yoast_wpseo_primary_' . $cat, true) == $term->term_id) {
      $primary_term = $term->name;
      $primary_termid = $term->term_id;
    }
  }
  $primary_term = ($primary_term !== '') ? $primary_term : $primary_term_bkp;
  $primary_termid = ($primary_termid !== '') ? $primary_termid : $primary_termid_bkp;
  if ($type == 'link') {
    return '<a rel="dofollow" href="' . get_category_link( $primary_termid ) . '" class="cat">' . $primary_term . '</a>';
  } else {
    return $primary_term;
  }
}