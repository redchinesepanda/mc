<?php // do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>
<?php // tc__f('rec' , __FILE__ , __FUNCTION__ ); ?>
<div id="main-wrapper" class="container">
   <div class="container" role="main">
        <div class="row">
            <?php // do_action( '__before_article_container'); ?>
                <div class="<?php // echo tc__f( '__screen_layout' , tc__f ( '__ID' ) , 'class' ) ?> article-container">
                    <header><h1 class="entry-title">403 Forbidden</h1></header>
            <div class="entry-content"><p>Access to this area is forbidden. Please go to the home page.</p></div>
        </div><!--.article-container -->
       <?php // do_action( '__after_article_container'); ?>
        </div><!--.row -->
    </div><!-- .container role: main -->
<?php // do_action( '__after_main_container' ); ?>
</div><!--#main-wrapper"-->
<?php // do_action( '__after_main_wrapper' ); ?>