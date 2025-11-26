<?php
/* url da pasta upsites no thema */
$upsites = get_template_directory() . '/upsites/';

/** 
 * After theme setup hook actions
 */
add_action('after_setup_theme', function () {

  add_theme_support('widgets');
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  // This theme uses wp_nav_menu() in two locations.
  register_nav_menus(
    array(
      'menu' => __('Top Menu', 'upsites'),
      'menufooter' => __('Footer Menu', 'upsites'),
    )
  );
  add_theme_support(
    'custom-logo',
    array(
      'height'      => 197,
      'width'       => 50,
      'flex-height' => true,
      'flex-width'  => true,
    )
  );
});


/** 
 * Load theme assets
 */
add_action('wp_enqueue_scripts', function () {
  $assets_src = get_template_directory_uri() . '/assets';
  $version = wp_get_theme()->get('Version');

  /* CSS default */
  wp_enqueue_style('font-awesome', "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", [], $version, 'all');
  /* end: CSS default */

  /* JS default */
  $site_url = get_bloginfo('url');
  $is_local = (
    strpos($site_url, 'local.wp4') !== false ||
    strpos($site_url, 'localhost') !== false ||
    strpos($site_url, '127.0.0.1') !== false ||
    strpos($site_url, '.local') !== false ||
    (defined('WP_DEBUG') && WP_DEBUG === true)
  );

  if ($is_local) {
    wp_enqueue_script('mainJS', "{$assets_src}/js/mainJS.js", ['jquery'], $version, true);
    wp_enqueue_script('scrollrevealJS', "{$assets_src}/js/scrollreveal.js", ['jquery'], $version, true);
  } else {
    wp_enqueue_script('mainJS', "{$assets_src}/js/mainJS.min.js", ['jquery'], $version, true);
    wp_enqueue_script('scrollrevealJS', "{$assets_src}/js/scrollreveal.min.js", ['jquery'], $version, true);
  }
  /* end: JS default */

  /**
   * Função para carregar CSS de uma página específica
   */
  function enqueue_page_css($page_name, $assets_src, $version, $is_local)
  {
    $css_file = get_template_directory() . "/assets/css/{$page_name}.css";
    $css_mobile_file = get_template_directory() . "/assets/css/{$page_name}-mobile.css";
    $css_min_file = get_template_directory() . "/assets/css/{$page_name}.min.css";
    $css_mobile_min_file = get_template_directory() . "/assets/css/{$page_name}-mobile.min.css";

    if ($is_local) {
      if (file_exists($css_file)) {
        $css_version = filemtime($css_file);
        wp_enqueue_style("page-{$page_name}", "{$assets_src}/css/{$page_name}.css", [], $css_version, 'screen and (min-width: 769px)');
      }
      if (file_exists($css_mobile_file)) {
        $css_mobile_version = filemtime($css_mobile_file);
        wp_enqueue_style("page-{$page_name}-mobile", "{$assets_src}/css/{$page_name}-mobile.css", [], $css_mobile_version, 'screen and (max-width: 768.9px)');
      }
    } else {
      if (file_exists($css_min_file)) {
        wp_enqueue_style("page-{$page_name}", "{$assets_src}/css/{$page_name}.min.css", [], $version, 'screen and (min-width: 769px)');
      } elseif (file_exists($css_file)) {
        wp_enqueue_style("page-{$page_name}", "{$assets_src}/css/{$page_name}.css", [], $version, 'screen and (min-width: 769px)');
      }
      if (file_exists($css_mobile_min_file)) {
        wp_enqueue_style("page-{$page_name}-mobile", "{$assets_src}/css/{$page_name}-mobile.min.css", [], $version, 'screen and (max-width: 768.9px)');
      } elseif (file_exists($css_mobile_file)) {
        wp_enqueue_style("page-{$page_name}-mobile", "{$assets_src}/css/{$page_name}-mobile.css", [], $version, 'screen and (max-width: 768.9px)');
      }
    }
  }

  $page_template = get_page_template_slug();
  $page_name = false;

  if ($page_template) {
    $template_map = [];
    $templates_dir = get_template_directory() . '/template-pages/';

    if (is_dir($templates_dir)) {
      $template_files = glob($templates_dir . '*.php');
      foreach ($template_files as $template_file) {
        $filename = basename($template_file, '.php');
        $template_path = 'template-pages/' . basename($template_file);
        $template_map[$template_path] = $filename;
      }
    }

    if (isset($template_map[$page_template])) {
      $page_name = $template_map[$page_template];
    } else {
      $template_basename = basename($page_template, '.php');
      $css_file = get_template_directory() . "/assets/css/{$template_basename}.css";
      if (file_exists($css_file)) {
        $page_name = $template_basename;
      }
    }
  }

  if ($page_name) {
    enqueue_page_css($page_name, $assets_src, $version, $is_local);

    if ($page_name === 'home') {
      if ($is_local) {
        wp_enqueue_script('slickJS', "{$assets_src}/js/slick.js", ['jquery'], $version, true);
      } else {
        wp_enqueue_script('slickJS', "{$assets_src}/js/slick.min.js", ['jquery'], $version, true);
      }
    }
  } elseif (is_single()) {
    enqueue_page_css('home', $assets_src, $version, $is_local);
    if ($is_local) {
      wp_enqueue_script('slickJS', "{$assets_src}/js/slick.js", ['jquery'], $version, true);
    } else {
      wp_enqueue_script('slickJS', "{$assets_src}/js/slick.min.js", ['jquery'], $version, true);
    }
  } else {
    if ($is_local) {
      $css_file = get_template_directory() . '/assets/css/main.css';
      $css_version = file_exists($css_file) ? filemtime($css_file) : $version;
      wp_enqueue_style('theme', "{$assets_src}/css/main.css", [], $css_version, 'all');
    } else {
      wp_enqueue_style('theme', "{$assets_src}/css/main.min.css", [], $version, 'all');
    }
  }
}, 999, 1);


/*add_action('admin_enqueue_scripts', function () {
  $assets_src = get_template_directory_uri() . '/assets';
  $version = wp_get_theme()->get('Version');

  wp_enqueue_style('admincss', "{$assets_src}/css/admin.css", [], $version, 'all');
  wp_enqueue_script('adminjs', "{$assets_src}/js/admin.js", ['jquery'], $version, true);

  wp_localize_script('adminjs', 'usAjaxAdmin', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('nonce')
  ));
  wp_enqueue_script('adminjs');
});*/


/* CUSTOMIZER_REPEATER_VERSION */
define('CUSTOMIZER_REPEATER_VERSION', '1.1.0');
require $upsites . 'customizer-repeater/inc/customizer.php';

/* US_SET_POST_VIEWS */
define('US_SET_POST_VIEWS', '1.1.0');
require $upsites . 'post-views/post-views.php';

/* US_CUSTOMIZER_CONTROLS */
define('US_CUSTOMIZER_CONTROLS', '1.1.0');
require $upsites . 'customizer-controls/customizer-controls.php';

/* US_CUSTOMIZER_REGISTER */
define('US_CUSTOMIZER_REGISTER', '1.1.0');
require $upsites . 'customizer-register/customizer-register.php';

/* US_COMMENTS */
define('US_COMMENTS', '1.1.0');
require $upsites . 'comments/comments.php';

/* US_PAGINATION */
/**
 * US_paging_nav($postcat, $paged, $maxpages)
 */
define('US_PAGINATION', '1.1.0');
require $upsites . 'pagination/pagination.php';

/* US_TERMS */
/** 
 * Return Category Primary
 * US_term_list(get_the_ID(), 'category', 'tag')
 * link = Return category more permalink
 * tags = Return only category text 
 */
define('US_TERMS', '1.1.0');
require $upsites . 'terms/terms.php';
