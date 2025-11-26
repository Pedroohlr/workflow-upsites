<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
?>
  <!-- main -->
  <main id="main">
    <!-- simple-page -->
    <section class="simple-page">
      <div class="container">
        <h1><?= the_title() ?></h1>
        <?= the_content() ?>

      </div>
    </section>
    <!-- end:simple-page -->

  </main>
  <!-- end:main -->
<?php
get_footer();