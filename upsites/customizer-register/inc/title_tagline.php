<?php

  $wp_customize->add_setting('US_link_facebook', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_facebook', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link facebook', 'upsites'),
  ));
  $wp_customize->add_setting('US_link_instagram', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_instagram', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link instagram', 'upsites'),
  ));
  $wp_customize->add_setting('US_link_linkedin', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_linkedin', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link linkedin', 'upsites'),
  ));
  $wp_customize->add_setting('US_link_twitter', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_link_twitter', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Link twitter', 'upsites'),
  ));
  
  $wp_customize->add_setting('US_copyright', array(
    'capability' => 'edit_theme_options',
  ));
  $wp_customize->add_control('US_copyright', array(
    'type' => 'text',
    'section' => 'title_tagline',
    'label' => __('Copyright', 'upsites'),
  ));