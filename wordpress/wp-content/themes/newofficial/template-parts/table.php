<?php 
if($_GET['denistest']):
    switch_to_blog( 1 );
    

    $footer_table = get_field('footer_table','options',false);
    $footer_table_title =get_field('footer_table_title','option',false);
    restore_current_blog();

    if( count( $footer_table ) ):
    ?>
    <style>
        .table-higlights{
            max-width: 800px;
            margin: 0 auto;
            background-color: var(--background-light);
            border: 1px solid var(--background-variant-2);
            color: var(--text-color-dark);
        }
        .table-higlights td {
            border: 1px solid var(--background-variant-2);
            padding: 15px;
        }
    </style>
    <section class="content-section light-section" data-name="Article" data-description="Without image, Long Content">
        <div class="container">
            <div class="fow flex-align-center">
                <div class="text-center typo-wrapper">
                    <h2><b><?php echo do_shortcode( $footer_table_title ); ?></b></h2>
                </div>
                <table class="table-higlights">
                    <tbody id="emojtable">
                        <?php foreach( $footer_table as $footer_table_item ): the_row(); ?>
                        <?php 
                        $varints = $footer_table_item['field_62dfaac22b2ac'];
                        ?>
                        <tr>
                            <td><?php echo do_shortcode( $footer_table_item['field_62dfaabc2b2ab'] ); ?></td>
                            <td><?php echo do_shortcode( $varints[array_rand( $varints )]['field_62dfaacc2b2ad'] ); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php
    endif;
endif;