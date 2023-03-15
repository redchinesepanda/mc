<?php

/*

Template Name: Billet
Template Post Type: legal_billet

*/

require_once('lib/Template.php');

require_once('lib/Billet.php');

?>
<html>
    <head>
        <title>Billet</title>
    </head>
    <body>
        <h1>Billet</h1>
        <?php Billet::render(); ?>
    </body>
</html>