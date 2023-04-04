<?php

/*

Template Name: Compilation
Template Post Type: page

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
    <body class="compilation">
        <h1>Compilation</h1>
        <?php CompilationMain::render(); ?>
    </body>
</html>