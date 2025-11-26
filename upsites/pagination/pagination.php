<?php

function US_paging_nav($posts, $paged, $maxpages) {

  /** Stop execution if there's only 1 page */
  if ($posts->max_num_pages <= 1)
    return;

  //$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
  $max   = intval($maxpages);

  /** Add current page to the array */
  if ($paged >= 1)
    $links[] = $paged;

  /** Add the pages around the current page to the array */
  if ($paged >= 3) {
    $links[] = $paged - 1;
    $links[] = $paged - 2;
  }

  if (($paged + 2) <= $max) {
    $links[] = $paged + 2;
    $links[] = $paged + 1;
  }

  echo '<div class="paginations">' . "\n";

  /** Previous Post Link */
  if (get_previous_posts_link()) {
    
    printf('<a rel="dofollow" href="%s" id="slick-prev" class="slick-prev slick-arrow" aria-label="Previous"><svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrowSlide"></use></svg></a>' . "\n", get_previous_posts_page_link());
  } else {
    printf('<a rel="dofollow" href="#" id="slick-prev" class="slick-prev slick-arrow" aria-label="Previous"><svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrowSlide"></use></svg></a>' . "\n", get_previous_posts_page_link());
  }
  echo '<div class="pagingInfo">';
  /** Link to first page, plus ellipses if necessary */
  if($paged <= 9) {
    echo '0' . $paged;
  } else {
    echo $paged;
  }
  echo ' • ';
  if($maxpages <= 9) {
    echo '0' . $maxpages;
  } else {
    echo $maxpages;
  }
  echo '</div>';
  /** Next Post Link */
  if (get_next_posts_link('next', $posts->max_num_pages)) {
    printf('<a rel="dofollow" href="%s" id="slick-next" class="slick-next slick-arrow" aria-label="Next" type="button"><svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrowSlide"></use></svg></a>' . "\n", get_next_posts_page_link());
  } else {
    printf('<a rel="dofollow" href="#" id="slick-next" class="slick-next slick-arrow" aria-label="Next" type="button"><svg class="icon"><use xlink:href="' . get_template_directory_uri() . '/assets/img/icons.svg#arrowSlide"></use></svg></a>' . "\n", get_next_posts_page_link());
  }
  echo '</div>' . "\n";
}
