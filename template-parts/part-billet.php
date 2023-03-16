<?php

require_once( 'lib/BilletTitle.php' );

echo '<pre>part-billet.php:' . print_r( $args, true ) . '</pre>';

?>
<style type="text/css">
    #<?php echo $args['billet-selector']; ?> .billet-left {
        background-color: <?php echo $args['billet-color']; ?>;
    }
</style>
<div id="<?php echo $args['billet-selector']; ?>" class="billet">
    <div class="billet-left">
        <a href="<?php echo $args['billet-url'] ?>" rel="nofollow">
            <img src="<?php echo $args['featured-image'] ?>" alt="<?php echo $args['billet-title'] ?>">
        </a>
        <a href="<?php echo $args['billet-url'] ?>">Review</a>
    </div>
    <div class="billet-center">
        <?php BilletTitle::render(); ?>
    </div>
    <div class="billet-right">
        <span class="billet-price">
            <a href="/go/boylesports-ie/" rel="nofollow">Bet €10 Get €40 In Free Bets</a>
        </span>
        <a href="/go/boylesports-ie/" rel="nofollow">
            BET NOW
        </a>
        <div class="spoiler">
            <span class="link_spoiler link_spoiler_bookmaker-1 click_me">
                Learn More
            </span>
        </div>
    </div>
    <div class="billet-spoiler">
        <div class="content_Spoiler_conteiner">
            <nav class="info-container-evaluate">
                <ul class="info-container-nav">
                    <li>
                        <p><b>Regulated By:</b></p>
                        <p>IE Revenue Commissioners</p>
                    </li>
                    <li>
                        <p><b>Licence №</b></p>
                        <p>1010113</p>
                    </li>
                    <li>
                        <p><b>Web Site:</b></p>
                        <p>www.boylesports.com</p>
                    </li>
                    <li>
                        <p><b>Founded:</b></p>
                        <p>1982</p>
                    </li>
                </ul>
            </nav>
            <div class="content_Spoiler_information">
                <div class="content_Spoiler_text">
                    <p>BoyleSports is one of the largest prominent gambling establishments.
                        BoyleSports betting site offers 30+ sports to bet on, as well as a vast
                        choice of markets for each sport and attractive free bets. Regardless of
                        whether you're a fan of the perennially popular Premier League or prefer
                        bowls betting, there are numerous possibilities available. It also provides
                        users with an attractive welcome package with BoyleSports Free bets.</p>
                </div>
                <div class="content_Spoiler__list">
                    <nav class="content_Spoiler__list-slider">
                        <ul class="content_Spoiler__list-slider-ul">
                            <li>
                                <p><b>Odds</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:70%">7/10</div>
                                </div>
                            </li>
                            <li>
                                <p><b>Apps</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:100%">10/10
                                    </div>
                                </div>
                            </li>
                            <li>
                                <p><b>Streaming</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:20%">2/10</div>
                                </div>
                            </li>
                            <li>
                                <p><b>Payment Methods</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:70%">7/10</div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <nav class="content_Spoiler__list-slider">
                        <ul class="content_Spoiler__list-slider-ul">
                            <li>
                                <p><b>Welcome Offers</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:70%">7/10</div>
                                </div>
                            </li>
                            <li>
                                <p><b>Other Promos</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:70%">7/10</div>
                                </div>
                            </li>
                            <li>
                                <p><b>Support</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:75%">7,5/10
                                    </div>
                                </div>
                            </li>
                            <li>
                                <p><b>Navigation</b></p>
                            </li>
                            <li>
                                <div class="progress-line">
                                    <div class="progress-line-percent" style="width:75%">7,5/10
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="content_Spoiler_ftr">
                <a href="https://match.center/ie/boylesports/"
                    class="content_Spoiler_btn-about">Read more about BoyleSports</a>
            </div>
        </div>
    </div>
    <div class="billet-footer">
        At Boyle, you can get €40 in Free bets as €30 in sports bets and a €10 Casino bonus. 30 days
        to qualify. The minimum free bet stake is €10. Minimum odds applied. The Free bets are
        applied to the first settlement of any qualifying bet. Free bets valid for 7 days. The
        Casino promotion has a separate time limit: you have 14 days to accept the €10 casino bonus,
        which is only valid for 3 days. Casino bonus 5x wagering and maximum redeemable €100. Cashed
        out/free bets won't apply.
    </div>
</div>