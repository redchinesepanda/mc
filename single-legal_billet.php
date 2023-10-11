<?php

/*

Template Name: Single Legal Billet
Template Post Type: legal_billet

*/

require_once( 'lib/LegalMain.php' );

?>
<html>
    <head>
        <?php YoastMain::print(); ?>
        <?php BilletMain::print(); ?>
    </head>
    <body class="legal-compilation">
        <?php echo BilletMain::render_billet(); ?>
    </body>
</html>