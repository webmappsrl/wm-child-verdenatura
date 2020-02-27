<?php

//todo check nonce!!!
$atts = $_POST;
// Attributes
extract( shortcode_atts(
    array(
        'post_type' => 'any',
        'term_id' => '',
        'rows' => '2',
        'posts_per_page' => get_option( 'posts_per_page' ),
        'post_id' => '',
        'paged' => '1',
        'posts_count' => '',
        'main_tax' => '',
        'post_ids' => '',
        'template' => 'default',
        'orderby' => '',
        'activity_color' => ''

    ),
    $atts
));

global $wm_anypost_bootstrap_col_type,
       $wm_anypost_global_taxonomies,
       $wm_anypost_template,
       $wm_anypost_post_type;


$title_link = get_the_permalink();
$current_post_type = get_post_type();
$post_id = get_the_ID();

// gets the promotion value from italian corrispondent if this route is in english 
$post_id_ita = '';
$promotion_value = '';
$promotion_name = get_field('promotion_name',$post_id);
$post_language_information = wpml_get_language_information($post_id);
foreach ($post_language_information as $item => $value){
    if ($item == 'language_code'){
        $post_language = $value;
    }
}
if ($post_language !== 'it' ) {
    $post_id_ita = apply_filters( 'wpml_object_id', $post_id, 'route', FALSE, 'it' );
}
if ($post_id_ita) {
    $promotion_value = get_field('promotion_value',$post_id_ita);
} else {
    $promotion_value = get_field('promotion_value',$post_id);
}

$get_the_post_thumbanil = '';
if(get_the_post_thumbnail_url()) {
    $get_the_post_thumbanil = get_the_post_thumbnail_url(get_the_ID() , 'medium_large');
} else {
    $verde_natura_image = wp_get_attachment_image_src(40702,array(300,201));
    $get_the_post_thumbanil = $verde_natura_image[0];
}

?>

<div class="col-sm-12 col-md-<?php echo $wm_anypost_bootstrap_col_type?> webmapp_shortcode_any_post post_type_<?php echo $wm_anypost_post_type?>">


    <div class="single-post-wm" style="border-bottom: solid <?php echo $activity_color?>;">
    <div class="webmapp_post-featured-img">
        <?php
        echo "<a href='$title_link' title=\"".get_the_title()."\">";

        ?>

        <figure class="webmapp_post_image" style="background-image: url('<?php echo $get_the_post_thumbanil;?>')">
            <div class="gallery-fdn">
                <?php

                $dog_friendly = get_field ('vn_meta_dog');
                if ( $dog_friendly)
                    echo "<img src='/wp-content/themes/wm-child-verdenatura/images/dog-friendly.jpg' class='df-card' alt='dog-friendly'>";


                $new = get_field( 'vn_new' );
                if( $new )
                    echo "<img src='/wp-content/themes/wm-child-verdenatura/images/new.png' class='card' alt='Novità'>";

                ?>
            </div>
        </figure>

        <div class="webmapp_post-title">
            <h2 style="background-color:<?php echo $activity_color; ?>">
                <?php the_title() ?>
            </h2>
        </div>

        <?php
        echo "</a>";
        ?>
    </div>
    <div class="webmapp_post_meta">
        <?php
        $desc_br = get_the_excerpt();
        if ( $desc_br )
            echo $desc_br; ?>
    </div>
            
            <div class="prezzo-container prezzo-tab"> <!-- prezzo start-->
                <p class="promotion-trip">
                    <?php
                        
                        if ( $promotion_value )
                        echo __( 'Discounted trip!' , 'wm-child-verdenatura' );
                    ?>
                </p> 
                <div class="prezzo">
                    <?php echo __('Prices from' , 'wm-child-verdenatura'); ?>
                    <span class="cifra <?php if ( $promotion_value){ echo 'old-price';}?>"><?php
                    $vn_prezzo = get_field('wm_route_price');
                    $lowest_price = explode('€',$vn_prezzo);
                    if ($lowest_price) {
                        echo $lowest_price[0];
                    } else {
                        echo $vn_prezzo;
                    }
                    ?>
                    € </span>
                    <?php if ( $promotion_value):?>
                    <span class="new-price">
                        <?php 
                            if ($lowest_price) {
                                echo $lowest_price[0] - $promotion_value;
                            } else {
                                echo $vn_prezzo - $promotion_value;
                            }
                        ?>
                    € </span>
                    <?php endif; ?>
                </div> 
            </div><!--.prezzo  end-->
    </div>

</div>
