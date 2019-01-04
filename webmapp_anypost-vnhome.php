<?php


global $wm_anypost_bootstrap_col_type,
       $wm_anypost_global_taxonomies,
       $wm_anypost_template,
       $wm_anypost_post_type;

$title_link = get_the_permalink();
$get_the_post_thumbanil = get_the_post_thumbnail_url(get_the_ID() ,'full');
$current_post_type = get_post_type();


?>

<div class="col-sm-12 col-md-<?php echo $wm_anypost_bootstrap_col_type?> webmapp_shortcode_any_post post_type_<?php echo $wm_anypost_post_type?>">



    <div class="webmapp_post-featured-img">
        <?php
        echo "<a href='$title_link' title=\"".get_the_title()."\">";

        $own_made = get_field( 'wm_fdn' );
        if ( $own_made )
            echo "<img src='/wp-content/themes/wm-child-verdenatura/images/logo-omino.jpg' alt='Fatto da noi'>";

        $new = get_field( 'vn_new' );
        if( $new )
            echo "<img src='/wp-content/themes/wm-child-verdenatura/images/new.png' id='card' alt='Novità'>";


        ?>

        <figure class="webmapp_post_image" style="background-image: url('<?php echo $get_the_post_thumbanil; ?>')">
        </figure>

        <div class="webmapp_post-title">
            <h2>
                <?php the_title() ?>
            </h2>
        </div>

        <?php
        echo "</a>";
        ?>
    </div>
    <div class="webmapp_post_meta">
        <?php
        $desc_br = get_field('vn_desc_min');
        if ( $desc_br )
            echo $desc_br;



        $price = get_field( 'vn_prezzo' );
        if ( $price )
        {
            $price = number_format( $price, 0, ',', '.');
            $sale_price_p = '';
            $sale_price = get_field( 'vn_prezzo_sc' );
            if ( $sale_price > 0 )
                $sale_price_p = number_format( $sale_price, 0, ',', '.') . ' € ';


            echo "<p class='prezzo-tab' >" . __('Prices from' , 'wm-child-verdenatura') . " <span class='vn-sale-price cifra'>$sale_price_p</span><span class='cifra'>$price €</span></p>";
        }


        ?>
    </div>



</div>
