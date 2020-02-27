<?php
add_shortcode( 'vn_home_slider', 'vn_render_home_silder' );
function vn_render_home_silder( ) {

    ob_start();
    $posts = get_posts(array(
        'numberposts'	=> -1,
        'post_type'		=> 'route',
        'meta_key'		=> 'vn_sih',
        'meta_value'	=> 1,
        'suppress_filters' => false
    ));

    ?>
    <div class="et_pb_module et_pb_fullwidth_slider_0 et_pb_slider et_slider_auto et_slider_speed_5000 et_slide_transition_to_next">
		<div class="et_pb_slides">

            <?php
            $counter = 0;
            foreach ($posts as $post):
                $post_id = $post->ID;
                $post_title = $post->post_title;
                $post_featured_image = get_the_post_thumbnail_url($post_id,'large');
                $post_permalink = get_permalink($post_id);
                $tax_targets = get_the_terms( $post_id, 'who' );
                $tax_activities = get_the_terms( $post_id, 'activity' );
                $price = get_field('wm_route_price',$post_id);
                // gets the promotion value from italian corrispondent if this route is in english 
                $post_id_ita = '';
                $promotion_value = '';
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
            ?>
                            <div class="et_pb_slide et_pb_slide_<?php echo $counter;?> et_pb_bg_layout_dark et_pb_media_alignment_center et-pb-active-slide" data-slide-id="et_pb_slide_<?php echo $counter;?>" style="background-image: url(<?php echo $post_featured_image;?>);">
                                <div class="et_pb_container clearfix">
                                    <div class="et_pb_slider_container_inner">
                                        <div class="et_pb_slide_description">
                                            <h2 class="et_pb_slide_title"><a href="<?php echo $post_permalink;?>"><?php echo $post_title;?></a></h2>
                                            <div class="et_pb_slide_content">
                                                <p style="text-align: center;"><?php $counter = 0; foreach($tax_targets as $tax_target){if ($counter>0){echo ' - ';} echo $tax_target->name;$counter ++;}?><br> <?php $counter = 0; foreach($tax_activities as $tax_activity){if ($counter>0){echo ' - ';} echo $tax_activity->name.' ';$counter ++;}?></p>
                                                <div class="prezzo-container prezzo-tab"> <!-- prezzo start-->
                                                    <p class="promotion-trip">
                                                        <?php
                                                            $promotion_name = get_field('wm_route_promotion_name',$post_id);
                                                            if ( $promotion_value )
                                                            echo __( 'Discounted trip!' , 'wm-child-verdenatura' );
                                                        ?>
                                                    </p> 
                                                    <div class="prezzo">
                                                    <?php echo __('Prices from' , 'wm-child-verdenatura'); ?>
                                                    <span class="cifra <?php if ( $promotion_value){ echo 'old-price';}?>"><?php
                                                    $vn_prezzo = get_field('wm_route_price',$post_id);
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
                                            <div class="et_pb_button_wrapper"><a class="home-slider-bottom" href="<?php echo $post_permalink;?>"><?php echo __('DETAILS','wm-child-verdenatura');?></a>
                                            </div>
                                        </div> <!-- .et_pb_slide_description -->
                                    </div>
                                </div> <!-- .et_pb_container -->
                            </div> <!-- .et_pb_slide -->
            <?php
            // endif;
            $counter ++;
            endforeach;
            ?>
        </div> <!-- .et_pb_slides -->
	</div>
    <?php

    $html = ob_get_clean();
    return $html;
}
