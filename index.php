<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

if ( is_home() ) {
	get_template_part( 'template-parts/home' );
} elseif ( is_author() ) {
	get_template_part( 'template-parts/author' );
} elseif ( is_archive() ) {
	get_template_part( 'template-parts/archive' );
} elseif ( is_search() ) {
	get_template_part( 'template-parts/search' );
} elseif ( is_404() ) {
	get_template_part( 'template-parts/error' );
} else {
	get_template_part( 'template-parts/error' );
}
get_footer();
