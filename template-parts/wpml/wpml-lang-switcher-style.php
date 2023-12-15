.lang-switcher .lang-current:not( .legal-new ) .lang-title::before {
    background-image: url('<?php echo $args['active']['src']; ?>');
}
.lang-switcher .lang-current.legal-new .lang-title::after {
    background-image: url('<?php echo $args['active']['src']; ?>');
}
<?php foreach( $args['languages'] as $lang ) : ?>
    .lang-switcher .locale-<?php echo $lang['id']; ?> {
        background-image: url('<?php echo $lang['src']; ?>');
    }
<?php endforeach; ?>