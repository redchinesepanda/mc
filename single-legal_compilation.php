<?php

/*

Template Name: Single Legal Compilation
Template Post Type: legal_compilation

*/

require_once( 'lib/LegalMain.php' );

?>
<html>
    <head>
        <?php YoastMain::print(); ?>
        <?php CompilationMain::print(); ?>
    </head>
    <body class="legal-compilation">
        <?php echo CompilationMain::render_compilation(); ?>
    </body>
</html>