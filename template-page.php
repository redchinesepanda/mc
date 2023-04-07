<?php

/*

Template Name: Legal Page
Template Post Type: page

*/

require_once( 'lib/LegalMain.php' );

require_once( 'lib/yoast/YoastMain.php' );

require_once( 'lib/tabs/CompilationTabs.php' );

?>
<html>
    <head>
        <?php YoastMain::print(); ?>
        <?php CompilationTabs::print(); ?>
    </head>
    <body class="legal-tabs">
        <?php CompilationTabs::render(); ?>
    </body>
</html>