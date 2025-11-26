<?php

function US_add_my_tc_button() {
  global $typenow;
  // check user permissions
  if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
  return;
  }
  // verify the post type
  if( ! in_array( $typenow, array( 'post', 'page' ) ) )
      return;
  // check if WYSIWYG is enabled
  if ( get_user_option('rich_editing') == 'true') {
      add_filter("mce_external_plugins", "US_add_tinymce_plugin");
      add_filter('mce_buttons', 'US_register_my_tc_button');
  }
}
add_action('admin_head', 'US_add_my_tc_button');

function US_add_tinymce_plugin($plugin_array) {
  $assets_src = get_template_directory_uri();
  $plugin_array['US_tc_textfeatured'] = "{$assets_src}/js/text-button.js";
  return $plugin_array;
}

function US_register_my_tc_button($buttons) {
  array_push($buttons, "US_tc_textfeatured");
  return $buttons;
}