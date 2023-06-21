<?php

/*

Template Name: Legal Compilation
Template Post Type: legal_compilation

*/

require_once( 'lib/LegalMain.php' );

require_once( 'lib/yoast/YoastMain.php' );

require_once( 'lib/compilation/CompilationMain.php' );

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