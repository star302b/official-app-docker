<?php $data = get_cryptocurrencies();
if( isset($data['coins']) ):
    ?>
    <section class="js--tickers-section" data-name="Tickers" data-description="...">
        <div class="ticker-section">
            <div class="js--tickers tickers-slider" style="display: flex;">
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
        </div>
    </section >
<?php
endif;
?>