<?php

function US_customizer_register($wp_customize)
{
  /**
   * title_tagline
   */
  include 'inc/title_tagline.php';

  /**
   * US_banners
   */
  //include 'inc/banners.php';

  /*
  $wp_customize->add_setting('US_banners_home_div_01', array(
    'sanitize_callback' => 'themename_sanitize',
  ));
  $wp_customize->add_control(
    new US_Separator_Control(
      $wp_customize,
      'US_banners_home_div_01',
      array(
        'type' => 'hr',
        'section' => 'US_banners_home',
      )
    )
  );
  */
}
add_action('customize_register', 'US_customizer_register');

/**
 * US_register_cpts
 */
include 'inc/register_cpts.php';

/**
 * US_register_taxes
 */
include 'inc/register_taxes.php';

/**
 * acf_add_local_field_group
 */
include 'inc/acf_fields.php';
