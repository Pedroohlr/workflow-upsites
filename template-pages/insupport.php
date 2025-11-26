<?php
/*
Template Name: In support
*/

/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

 $maintenance_mode = get_theme_mod('US_maintenance_mode');
  if(!$maintenance_mode) {
    if (current_user_can('edit_themes') || is_user_logged_in()) {
    } else {
			$custom_page_url = '"'.home_url().'"';
      wp_redirect( $custom_page_url , 301);
		}
  }

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <!-- main -->
  <main class="relative">

    <!-- insupport -->
    <section class="insupport">
      <div class="container">
				<div class="grid">
					<div class="text">
						<div class="logo">
							<?php
							$the_custom_logo = get_theme_mod('custom_logo');
							$site_name = get_bloginfo('name');
							$tagline   = get_bloginfo('description', 'display');
							if (function_exists('the_custom_logo') &&  has_custom_logo()) {
								echo '<a href="' . esc_url(home_url('/')) . '" rel="home" title="' . get_bloginfo('name') . '"><img src="' . esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))) . '" alt="' . get_bloginfo('name') . '"  /></a>';
							}
							?>
						</div>
						<h1><span><b>conta</b> com a gente!</span> Em breve o <b>maior portal de contabilidade</b> do Brasil</h1>
					</div>
				</div>
      </div>
			<div class="footer-insupport absolute-bottom">
				<p>© 2023 – Contabilidade Facilitada | Todos os direitos reservados<br>Usamos os cookies de seu navegador para garantir uma experiência melhor em nosso site!</p>
			</div>
    </section>
    <!-- end:insupport -->
  </main>
  <!-- end:main -->

<?php // get_footer(); ?>




