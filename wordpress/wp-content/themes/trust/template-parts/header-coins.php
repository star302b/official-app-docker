<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" />

<style>
    ul.coin-ticker{
        list-style: none;
    }
    .builder-item--primary-menu .nav-menu-primary > .nav-ul li:not(.woocommerce-mini-cart-item):hover > a, .builder-item--primary-menu .nav-menu-primary > .nav-ul li:hover > .has-caret > a, .builder-item--primary-menu .nav-menu-primary > .nav-ul li:hover > .has-caret{
        color: #22898c;
    }
    .coin-ticker{
        overflow: hidden;
        max-height: 60px;
        box-shadow: 0 2px 3px rgb(0 0 0 / 15%);
        padding: 10px 15px;

    }
    .coin-ticker-wrap{
        z-index: 2;
        width: 100%;
    }
    .crypto-item-container{
        display: flex;
        align-items: center;
    }
    .crypto-item-container img{
        height: 35px;
        width: auto;
        margin-right: 10px;
    }
    .crypto-item-container .crypto-item-cont-text{

    }
    .crypto-item-container .crypto-item-cont-text .crypto-item-cont-text-name{
        font-size: 13px;
        line-height: 15px;
    }
    .crypto-item-container .crypto-item-cont-text .up-change{
        font-size: 13px;
        line-height: 15px;
    }
    .crypto-item-container .crypto-item-cont-text .down-change{
        font-size: 13px;
        line-height: 15px;
    }
</style>
<?php $data = get_cryptocurrencies();
if( isset($data['coins']) ):
?>
<div style="background-color: white" class="coin-ticker-wrap">
<div class="coin-ticker marquee js--open-modal" href="#register">
    <div class="slid-wrap-new" style="display: flex;">
        <?php foreach( $data['coins'] as $curr_key => $curr_data ){

            if( 25 == $curr_key ) break;

            $move = $curr_data['priceChange1d'];
//            print_r($curr_data)
                ?>
                <div>
                    <div class="crypto-item-container">
                        <img src="<?php echo $curr_data['icon']; ?>" alt="<?php echo $curr_data['name'];?>">
                        <div class="crypto-item-cont-text">
                            <div class="crypto-item-cont-text-name">
                                <span class="coin-name"><strong><?php echo $curr_data['symbol'];?>/EUR</strong> 24h</span>
                            </div>
                            <div class="<?php echo  ( 0 < $move ? 'up-change' : 'down-change' ); ?>">
                                <span class="coin-price">€<?php echo number_format( $curr_data['price'], 2 ); ?></span>
                                <span class="coin-value"><?php echo  ( 0 < $move ? '+' : '' ); ?><?php echo number_format(  $move, 2 ); ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        } ?>
    </div>
</div></div>
<?php
endif;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function($){
        $(window).scroll(function(e){
            var $el = $('.coin-ticker-wrap');
            var isPositionFixed = ($el.css('position') == 'fixed');
            if ($(this).scrollTop() > $('.site-header').outerHeight() && !isPositionFixed){
                $el.css({'position': 'fixed', 'top': '0px'});
            }
            if ($(this).scrollTop() < $('.site-header').outerHeight() && isPositionFixed){
                $el.css({'position': 'static', 'top': '0px'});
            }
        });

        $('.coin-ticker .slid-wrap-new').slick({
            slidesToShow: 10,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            infinite: true,
            autoplaySpeed: 1500,
            responsive: [
                {
                    breakpoint: 1650,
                    settings: {
                        slidesToShow: 7,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 1450,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>