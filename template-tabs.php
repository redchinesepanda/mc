<?php

/*

Template Name: Template Legal Tabs
Template Post Type: page

*/

require_once( 'lib/LegalMain.php' );

?>
<html>
    <head>
        <?php YoastMain::print(); ?>
        <?php CompilationTabs::print(); ?>
    </head>
    <body class="legal-tabs">
        <?php echo CompilationTabs::render(); ?>
    </body>
</html>