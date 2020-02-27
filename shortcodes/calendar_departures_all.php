
<?php

add_shortcode( 'vn_calendar_all', 'calendar_departures_all_shortcode' );
function calendar_departures_all_shortcode( $atts ) {
   
   ob_start();
   $calendar_json = "http://vnpreprod.webmapp.it/calendar_departures_all.json";
   $c = json_decode(file_get_contents($calendar_json),TRUE);
   $routes = $c['features'];

   $all_routes_departures = array();
   foreach ($routes as $route) {
        $post_id = $route['properties']['id'];
        $departures = $route['properties']['all_dates'];
        $route_departures = array();
        foreach ($departures as $date) {
            $all_routes_departures[] = array('date'=>$date, 'id' => $post_id);
        }
        // array_push($all_routes_departures, $route_departures);
    }
    // print_r($all_routes_departures);
    // echo '<br>';
    function date_compare($a, $b)
    {
        $t1 = strtotime($a['date']);
        $t2 = strtotime($b['date']);
        return $t1 - $t2;
    }    
    usort($all_routes_departures, 'date_compare');
    // print_r($all_routes_departures);

   ?>
   <div id="tabs" class="vn-tab-departures">
    <?php
    foreach ($all_routes_departures as $route_date) {
        $route_departure = $route_date['date'];
        $route_id =  $route_date['id'];
        
        foreach ($routes as $r) {
            $post_id = $r['properties']['id'];
            $translation = '';
            $lang = '';
            $en_id = ''; 
            if (isset($_GET['lang'])){
                $lang = $_GET['lang'];
                if (array_key_exists("translations",$r['properties']) && array_key_exists($lang,$r['properties']['translations'])  ) {
                    $title = $r['properties']['translations'][$lang]['name'];
                    $en_id = $r['properties']['translations'][$lang]['id'];
                    $translation = true;
                } else {
                    $title = $r['properties']['name'];
                }
            } else {
                $title = $r['properties']['name'];
            }
            if ($route_id == $post_id && $lang == 'en') {
                if ($translation) {
                $en_url = get_the_permalink($en_id);
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

                $get_the_post_thumbanil = '';
                if(get_the_post_thumbnail_url()) {
                    $get_the_post_thumbanil = get_the_post_thumbnail_url(get_the_ID() , 'medium_large');
                } else {
                    $verde_natura_image = wp_get_attachment_image_src(40702,array(300,201));
                    $get_the_post_thumbanil = $verde_natura_image[0];
                }
                $url = $en_url;
                $image = $r['properties']['image'];
                //$departures = $r['properties']['all_dates'];
                $duration = $r['properties']['duration'];
                $price = $r['properties']['price'];
                $activities = $r['properties']['wm_route_tax_activity_id'];
                $activity_name = '';
                $tax_term_id = '';
                foreach ($activities as $activity ) {
                    $activity_name = $activity['name'];
                    $tax_term_id = $activity['term_id'];
                }
                $term = 'term_'.$tax_term_id;
                $iconimage = get_field('wm_taxonomy_featured_icon',$term);
                $iconimageurl = $iconimage['url'];
                $next_departure = $route_departure;
                $next_departure_month = explode('-',$next_departure);
                $dayNumber = $next_departure_month[2];
                $yearNumber = $next_departure_month[0];
                // if ( $departures ) {
                    ?>
                    <div class="col-sm-12 col-md-12 shortcode_caldepartures post_type_route">
                        <div class="calendar-single-post-wm">
                            <div class="webmapp_post-featured-img">
                                <?php
                                echo "<a href='$url' title='$title'>";
                                ?>
                                <figure class="webmapp_post_image" style="background-image: url('<?php echo $image;?>')"></figure>
                                <?php
                                echo "</a>";
                                ?>
                            </div>
                            <div class="webmapp_post_meta">
                                <div class="webmapp_post-title">
                                    <?php
                                    echo "<a href='$url' title='$title' class='departure-title'>";
                                    echo $title;
                                    echo "</a>";
                                    ?>
                                    <p>
                                        <?php echo __( 'Duration:' , 'wm-child-verdenatura' ).' '. $duration.' '.__( 'days' , 'wm-child-verdenatura' ); ?>
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
                                </div>
                            </div>
                            <div class="webmapp_post_date">
                                    <div>
                                        <img src="<?php echo $iconimageurl;?>" style="width:40px;">
                                    </div>  
                                    <p>
                                        <span class="d-date"><?php echo $dayNumber.'/'.$next_departure_month[1]; ?></span>
                                        <span class="y-date"><?php echo $yearNumber; ?></span>
                                    </p>
                            </div>
                        </div>
                    </div>
                    <?php
                    // }
                }
                } elseif ($route_id == $post_id) {
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

                $get_the_post_thumbanil = '';
                if(get_the_post_thumbnail_url()) {
                    $get_the_post_thumbanil = get_the_post_thumbnail_url(get_the_ID() , 'medium_large');
                } else {
                    $verde_natura_image = wp_get_attachment_image_src(40702,array(300,201));
                    $get_the_post_thumbanil = $verde_natura_image[0];
                }
                $url = $r['properties']['url'];
                $image = $r['properties']['image'];
                //$departures = $r['properties']['all_dates'];
                $duration = $r['properties']['duration'];
                $price = $r['properties']['price'];
                $activities = $r['properties']['wm_route_tax_activity_id'];
                $activity_name = '';
                $tax_term_id = '';
                foreach ($activities as $activity ) {
                    $activity_name = $activity['name'];
                    $tax_term_id = $activity['term_id'];
                }
                $term = 'term_'.$tax_term_id;
                $iconimage = get_field('wm_taxonomy_featured_icon',$term);
                $iconimageurl = $iconimage['url'];
                $next_departure = $route_departure;
                $next_departure_month = explode('-',$next_departure);
                $dayNumber = $next_departure_month[2];
                $yearNumber = $next_departure_month[0];
                // if ( $departures ) {
                    ?>
                    <div class="col-sm-12 col-md-12 shortcode_caldepartures post_type_route">
                        <div class="calendar-single-post-wm">
                            <div class="webmapp_post-featured-img">
                                <?php
                                echo "<a href='$url' title='$title'>";
                                ?>
                                <figure class="webmapp_post_image" style="background-image: url('<?php echo $image;?>')"></figure>
                                <?php
                                echo "</a>";
                                ?>
                            </div>
                            <div class="webmapp_post_meta">
                                <div class="webmapp_post-title">
                                    <?php
                                    echo "<a href='$url' title='$title' class='departure-title'>";
                                    echo $title;
                                    echo "</a>";
                                    ?>
                                    <p>
                                        <?php echo __( 'Duration:' , 'wm-child-verdenatura' ).' '. $duration.' '.__( 'days' , 'wm-child-verdenatura' ); ?>
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
                                </div>
                            </div>
                            <div class="webmapp_post_date">
                                    <div>
                                        <img src="<?php echo $iconimageurl;?>" style="width:40px;">
                                    </div>  
                                    <p>
                                        <span class="d-date"><?php echo $dayNumber.'/'.$next_departure_month[1]; ?></span>
                                        <span class="y-date"><?php echo $yearNumber; ?></span>
                                    </p>
                            </div>
                        </div>
                    </div>
                    <?php
                    // }
                }
            } 
        }?>
    </div>
    <script>
        ( function($) {
            // var date = new Date();
            // month = date.getMonth();
            // console.log(month);
            // // $('.tabs-departures-tab li:eq('+month+')').prop('aria-selected', true);
            // // $('.tabs-departures-tab li:eq('+month+')').prop('aria-expanded', true);
            // $('#tabs').tabs({
            //     active: month
            // });

            $( "#tabs" ).tabs({
                activate: function( event, ui ) {
                    ui.newPanel.find('.webmapp_post_image').each(function(i,e){
                        force_aspect_ratio($(e));
                    } );
                }
            });
        } )(jQuery);

        jQuery(function(){
            window.et_pb_smooth_scroll = () => {};
        });
    </script>
    <?php 
    
   return ob_get_clean(); 

}