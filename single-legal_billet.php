<?php

/*

Template Name: Legal Billet
Template Post Type: legal_billet

*/

require_once( 'lib/LegalMain.php' );

require_once( 'lib/yoast/YoastMain.php' );

require_once( 'lib/billet/BilletMain.php' );

?>
<html>
    <head>
        <?php YoastMain::print(); ?>
        <?php BilletMain::print(); ?>
    </head>
    <body class="legal-compilation">
        <h1>Billet</h1>
        <?php BilletMain::render(); ?>
    </body>
</html>