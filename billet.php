<?php

/*

Template Name: Billet
Template Post Type: legal_billet

*/

require_once('lib/Head.php');

require_once('lib/Template.php');

require_once('lib/Billet.php');

Head::register();

?>
<html>
    <head>
        <title>Billet</title>
        <?php Head::print(); ?>
    </head>
    <body>
        <h1>Billet</h1>
        <?php Billet::render(); ?>
    </body>
</html>