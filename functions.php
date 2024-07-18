<?php

wp_redirect( 'https://old.match.center/', '301' );

require_once( 'lib/LegalMain.php' );

LegalMain::register();

?>