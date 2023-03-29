<?php

/*

Template Name: Billet
Template Post Type: legal_billet

*/

require_once( 'lib/Head.php' );

require_once( 'lib/LegalMain.php' );

require_once( 'lib/billet/BilletMain.php' );

?>
<html>
    <head>
        <title>Billet</title>
        <?php Head::print(); ?>
    </head>
    <body class="legal-compilation">
        <h1>Billet</h1>
        <?php BilletMain::render(); ?>
    </body>
</html>