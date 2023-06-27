<?php

/*

Template Name: Template Legal Compilation
Template Post Type: legal_compilation

*/

require_once( 'lib/LegalMain.php' );

?>
<html>
    <head>
        <?php YoastMain::print(); ?>
        <?php CompilationMain::print(); ?>
    </head>
    <body class="compilation-single">
        <?php echo CompilationMain::render(); ?>
    </body>
</html>