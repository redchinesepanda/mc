/* .lang-switcher .locale-<?php echo $args['active']['id']; ?> {
    background-image: url('<?php echo $args['active']['src']; ?>');
} */
.lang-switcher .lang-current .lang-title::before {
    background-image: url('<?php echo $args['active']['src']; ?>');
}
<?php foreach( $args['languages'] as $lang ) : ?>
    .lang-switcher .locale-<?php echo $lang['id']; ?> {
        background-image: url('<?php echo $lang['src']; ?>');
    }
<?php endforeach; ?>