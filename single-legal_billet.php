<?php

/*

Template Name: Billet
Template Post Type: legal_billet

*/

require_once( 'lib/LegalMain.php' );

require_once( 'lib/yoast/YoastMain.php' );

require_once( 'lib/billet/BilletMain.php' );

YoastMain::get();

?>
<html>
    <head>
        <title><?php echo ''; ?></title>
        <?php BilletMain::print(); ?>
    </head>
    <body class="legal-compilation">
        <h1>Billet</h1>
        <?php BilletMain::render(); ?>
    </body>
</html>