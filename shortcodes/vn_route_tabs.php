<?php


add_shortcode( 'vn_route_tabs', 'vn_render_route_tabs_shortcode' );
// [bartag foo="foo-value"]
function vn_render_route_tabs_shortcode() {

ob_start();


//----------------------- query in variable products of route --------
//var
$prduct_list_hotel = array();
$attributes_name_hotel = array();
$variations_name_price = array();
$list_all_variations_name = array();
$has_hotel = false;
$has_extra = false;

$products = get_field('product');
if( $products ){
    foreach( $products as $p ){ // variables of each product
    $product = wc_get_product($p); 
        if($product->is_type('variable')){
            $product_with_variables = wc_get_product( $p );
            $category = $product_with_variables->get_categories();
            $attributes_list = $product_with_variables->get_variation_attributes();
            foreach ($attributes_list as $value => $key ) {
                $product_attribute_name = $value;
            }
            if(strip_tags($category) == 'hotel'){
                $has_hotel = true;
                array_push($attributes_name_hotel,$product_attribute_name);
                $product_variation_name_price = array();
                foreach($product->get_available_variations() as $variation ){

                    // hotel Name
                    $attributes = $variation['attributes'];
                    $variation_name = '';
                    foreach($attributes as $name_var){
                        $variation_name = $name_var;
                    }
                    // Prices
                    $price = $variation['price_html'];
                    $variation_name_price = array($variation_name => $variation['price_html']);
                    $list_all_variations_name += array($variation_name => $variation['price_html']);
                    $product_variation_name_price += $variation_name_price;
                }
                $variations_name_price += array( $product_attribute_name =>$product_variation_name_price);
            }
            if(strip_tags($category) == 'extra'){
                $has_extra = true;
                $extra_variation_name_price = array();
                foreach($product->get_available_variations() as $variation ){

                    // Extra Name
                    $xattributes = $variation['attributes'];
                    $xvariation_name = '';
                    foreach($xattributes as $name_var){
                        $xvariation_name = $name_var;
                    }
                    // Prices
                    $xprice = $variation['price_html'];
                    $extra_name_price = array($xvariation_name => $variation['price_html']);
                    $extra_variation_name_price += $extra_name_price;
                }
            }
        }
    }

}
//  add the lowest price to vn_prezzp ACF : price from... 
$lowest_price_list = array();
foreach ( $variations_name_price as $var ) {
    array_push($lowest_price_list , $var['adult']);
}
$lowest_price = min($lowest_price_list);
$lowest_price = preg_replace('/&.*?;/', '', $lowest_price);
$lowest_price = strip_tags($lowest_price);
$lowest_price = (float)$lowest_price;
update_field('wm_route_price', $lowest_price);
?>




<div id="tabs" class="vn-tab-route">
  <ul>
    <li><a href="#tabs-1" style="border-right: solid 2px #0F7A68;"><?php
            echo __('HIGHLIGHTS' ,'wm-child-verdenatura');
            ?></a></li>
    <li><a href="#tabs-2" style="border-right: solid 2px #0F7A68;"><?php
            echo __('ITINERARY' ,'wm-child-verdenatura');
            ?></a></li>
    <li><a href="#tabs-3" style="border-right: solid 2px #0F7A68;"><?php
            echo __('TRIP INFO' ,'wm-child-verdenatura');
            ?></a></li>
      <li><a href="#tabs-4" style="border-right: solid 2px #0F7A68;"><?php
              echo __('DATES AND PRICES' ,'wm-child-verdenatura');
              ?></a></li>
      <li><a href="#tabs-5" ><?php
              echo __('HOW TO GET THERE' ,'wm-child-verdenatura');
              ?></a></li>
  </ul>

  <div id="tabs-1">
      <p class="vn-note-route">
          <?php
          $vn_note = get_field('vn_note');
          if ( $vn_note)
              echo $vn_note;
          ?>


      </p>
    <p class="desc-route">
        <?php
        $vn_desc = get_field('vn_desc');
        if ( $vn_desc )
            echo $vn_desc;
        ?>
    </p>
  </div>

  <div id="tabs-2">
    <p class="prog-route">
        <?php
        $vn_prog = get_field('vn_prog');
        if ( $vn_prog )
            echo $vn_prog;
        ?>
    </p>
  </div>

  <div id="tabs-3">
    <p class="carat-route">
        <?php
        $vn_scheda_tecnica = get_field('vn_scheda_tecnica');
        if ( $vn_scheda_tecnica )
            echo $vn_scheda_tecnica;
        ?>

    </p>
  </div>

    <div id="tabs-4">
        <div class="durata-preventivo"> <!------------ Duration -->
            <span class='durata-txt'> 
            <p class="tab-section"> 
                <?php
                if (get_field('vn_durata')) {
                    echo __('Duration:' ,'wm-child-verdenatura');
                }
                ?>
            </p>
            </span>
            <?php $days = get_field('vn_durata');
            if ( $days )
            {
                $nights = $days - 1;
                ?>
                <p class="part-e-pre"></p>
                <?php
                echo "<span class=''>" . "$days" . __( 'days' , 'wm-child-verdenatura' ) . "/$nights" . __( 'nights' , 'wm-child-verdenatura' ) ;
                ?>
                </span>

                <?php

                $vn_note_dur = get_field( 'vn_note_dur' );
                if ( $vn_note_dur )
                    echo "<span class='webmapp_route_duration_notes'> ($vn_note_dur)</span>";
            }
            ?>
        </div>
        
        <div class="departure-preventivo"> <!------------ Departure / Partenze -->
            <span class='durata-txt'>
                <p class="tab-section">
                    <?php
                    if( have_rows('departures_periods') ){
                    echo __('Departures:' ,'wm-child-verdenatura');}?>
                </p>
            </span>
            
            <?php
                if( have_rows('departures_periods') ): ?>
                <p class="part-e-pre"></p>
                
                <div class="grid-container-period">
                
                    <?php while( have_rows('departures_periods') ): the_row(); 
            
                    // vars
                    $name = get_sub_field('name');
                    $start = get_sub_field('start');
                    $stop = get_sub_field('stop');
                    $week_days = get_sub_field('week_days');
                    $dateformatstring = "l";
            
                    ?>
            
                    <div class="departure_start">
                        <?php if( $start ): ?>
                            <p><?php echo __('From:' ,'wm-child-verdenatura').' '.$start; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="departure_stop">
                        <?php if( $stop ): ?>
                            <p><?php echo __('To:' ,'wm-child-verdenatura').' '.$stop; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="departure_week_days">
                        <?php if( $week_days ): ?>
                            <ul>
                                <?php if (count($week_days) == 7) { ?>
                                    <li style="display: inline;" ><?php echo __('Every day' ,'wm-child-verdenatura'); ?></li>
                                    <?php }else { ?>
                                        <span><?php echo __('Only' ,'wm-child-verdenatura').' '; ?></span>
                                        <?php 
                                        $i = 0;
                                        $len = count($week_days);
                                        foreach( $week_days as $week_day ): 
                                            if ($i == 0){ ?>
                                                <li style="display: inline;" ><?php echo date_i18n($dateformatstring, strtotime($week_day)); ?></li>
                                            <?php } elseif ($i == $len -1){ ?>
                                                <?php echo __('and' ,'wm-child-verdenatura').' '; ?><li style="display: inline;" ><?php echo date_i18n($dateformatstring, strtotime($week_day)); ?></li>
                                            <?php } else { ?>
                                            <span><?php echo __(',' ,'wm-child-verdenatura').' '; ?></span><li style="display: inline;" ><?php echo date_i18n($dateformatstring, strtotime($week_day)); ?></li>
                                            <?php } $i++ ;?>
                                <?php endforeach; } ?>
                            </ul>
                        <?php endif; ?>
                </div>
            
                <?php endwhile; ?>
            
                </div>
            
                <?php endif; ?>
                
                <?php // ---------- single departures ----------------//
                if( have_rows('departure_dates') ): ?>
                <div class="single-departure">
                        <p class="tab-section"><?php echo __('Single departures' ,'wm-child-verdenatura');?></p>
                </div>
                <div class="grid-container-single">
                
                <?php while( have_rows('departure_dates') ): the_row(); 
            
                    // vars
                    $date = get_sub_field('date');            
                    ?>
            
                    <div class="departure_name">
                        <?php if( $date ): ?>
                            <p><?php echo $date; ?></p>
                        <?php endif; ?>
                    </div>
            
                <?php endwhile; ?>
            
                </div>
            
                <?php endif; ?> <!-- End ---------- single departures -->
        </div>

        <div class="quotes-preventivo">
            <span class='durata-txt'> <!------------ quote ---------------------->
            <p class="tab-section"> 
                <?php
                if( have_rows('product') ){
                echo __('Hotel quotes: ' ,'wm-child-verdenatura');}?>
            </p>
            </span>
            <?php 
            if ($has_hotel){  //----------- start hotel product table
            ?>
            <p class="part-e-pre"></p>
            <table class="departures-quotes">
                <thead>
                    <tr>
                        <th></th>
                        <?php
                        foreach ($attributes_name_hotel as $hotel){
                        ?>
                        <th class="tab-section-quotes"><?php echo $hotel;?></th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php  // row adult --------------------------------------------------------
                    if(array_key_exists('adult',$list_all_variations_name)) {           
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('Adult' ,'wm-child-verdenatura');
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == 'adult'){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                    }
                    ?> <!---- END row adult ---->
                    <?php  // row kid1 --------------------------------------------------------
                    foreach ($list_all_variations_name as $var_name =>$value){
                        $name_explode = explode ('-',$var_name);
                        if (!empty($name_explode) && $name_explode[0] == 'kid1') {
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('kid' ,'wm-child-verdenatura').' '. __('till age' ,'wm-child-verdenatura').' '.$name_explode[1];
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == $var_name){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                        }
                    }
                    ?> <!---- END row kid1 ---->
                    <?php  // row kid2 --------------------------------------------------------
                    foreach ($list_all_variations_name as $var_name =>$value){
                        $name_explode = explode ('-',$var_name);
                        if (!empty($name_explode) && $name_explode[0] == 'kid2') {
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('kid' ,'wm-child-verdenatura').' '. __('till age' ,'wm-child-verdenatura').' '.$name_explode[1];
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == $var_name){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                        }
                    }
                    ?> <!---- END row kid2 ---->
                    <?php  // row kid3 --------------------------------------------------------
                    foreach ($list_all_variations_name as $var_name =>$value){
                        $name_explode = explode ('-',$var_name);
                        if (!empty($name_explode) && $name_explode[0] == 'kid3') {
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('kid' ,'wm-child-verdenatura').' '. __('till age' ,'wm-child-verdenatura').' '.$name_explode[1];
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == $var_name){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                        }
                    }
                    ?> <!---- END row kid3 ---->
                    <?php  // row kid4 --------------------------------------------------------
                    foreach ($list_all_variations_name as $var_name =>$value){
                        $name_explode = explode ('-',$var_name);
                        if (!empty($name_explode) && $name_explode[0] == 'kid4') {
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('kid' ,'wm-child-verdenatura').' '. __('till age' ,'wm-child-verdenatura').' '.$name_explode[1];
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == $var_name){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                        }
                    }
                    ?> <!---- END row kid4 ---->
                    <?php  // row adult-extra --------------------------------------------------------
                    if(array_key_exists('adult-extra',$list_all_variations_name)) {           
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('Extra bed for adult' ,'wm-child-verdenatura');
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == 'adult-extra'){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                    }
                    ?> <!---- END row adult-extra ---->
                    <?php  // row adult-single --------------------------------------------------------
                    if(array_key_exists('adult-single',$list_all_variations_name)) {           
                    ?>
                        <tr>  
                            <th>
                                <?php
                                echo __('Single room for adult' ,'wm-child-verdenatura');
                                ?>
                            </th>
                                <?php
                                foreach ($variations_name_price as $cat) {
                                ?>
                                <td>
                                <?php
                                    $not_exist = false;
                                    foreach ($cat as $var => $value) {
                                        if ($var == 'adult-single'){
                                            echo $value;
                                            $not_exist = true;
                                        } 
                                    }
                                    if ($not_exist == false) {
                                        echo '<span>-</span>';
                                    }
                                ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>
                    <?php
                    }
                    ?> <!---- END row adult-single ---->
                </tbody>       
            </table>
            <?php
            }  //----------- END hotel product table
            ?>
        </div> <!---- END  -------- quote hotel alberghi -->

        <div class="quotes-preventivo"> <!------------ quote extra ---------------------->
            <span class='durata-txt'> 
            <p class="tab-section"> 
                <?php
                if( $has_extra ){ //have_rows('product')
                echo __('Extra quotes: ' ,'wm-child-verdenatura');}?>
            </p>
            </span>
            <?php 
            if ($has_extra){  //----------- start extra product table
            ?>
            <p class="part-e-pre"></p>
            <table class="departures-quotes">
                <tbody>
                        <?php  // row bike --------------------------------------------------------
                        if(array_key_exists('bike',$extra_variation_name_price)) {           
                        ?>
                            <tr>  
                                <th>
                                    <?php
                                    echo __('Bike' ,'wm-child-verdenatura');
                                    ?>
                                </th>
                                    
                                <td>
                                <?php
                                    echo $extra_variation_name_price['bike'];
                                    ?>
                                </td>
                                   
                            </tr>
                        <?php
                        }
                        ?> <!---- END row bike ---->
                        <?php  // row ebike --------------------------------------------------------
                        if(array_key_exists('ebike',$extra_variation_name_price)) {           
                        ?>
                            <tr>  
                                <th>
                                    <?php
                                    echo __('E-Bike' ,'wm-child-verdenatura');
                                    ?>
                                </th>
                                    
                                <td>
                                <?php
                                    echo $extra_variation_name_price['ebike'];
                                    ?>
                                </td>
                                   
                            </tr>
                        <?php
                        }
                        ?> <!---- END row ebike ---->
                        <?php  // row kidbike --------------------------------------------------------
                        if(array_key_exists('kidbike',$extra_variation_name_price)) {           
                        ?>
                            <tr>  
                                <th>
                                    <?php
                                    echo __('Kid bike' ,'wm-child-verdenatura');
                                    ?>
                                </th>
                                    
                                <td>
                                <?php
                                    echo $extra_variation_name_price['kidbike'];
                                    ?>
                                </td>
                                   
                            </tr>
                        <?php
                        }
                        ?> <!---- END row kidbike ---->
                        <?php  // row babyseat --------------------------------------------------------
                        if(array_key_exists('babyseat',$extra_variation_name_price)) {           
                        ?>
                            <tr>  
                                <th>
                                    <?php
                                    echo __('Babyseat' ,'wm-child-verdenatura');
                                    ?>
                                </th>
                                    
                                <td>
                                <?php
                                    echo $extra_variation_name_price['babyseat'];
                                    ?>
                                </td>
                                   
                            </tr>
                        <?php
                        }
                        ?> <!---- END row babyseat ---->
                        <?php  // row bikewarranty --------------------------------------------------------
                        if(array_key_exists('bikewarranty',$extra_variation_name_price)) {           
                        ?>
                            <tr>  
                                <th>
                                    <?php
                                    echo __('Bikewarranty' ,'wm-child-verdenatura');
                                    ?>
                                </th>
                                    
                                <td>
                                <?php
                                    echo $extra_variation_name_price['bikewarranty'];
                                    ?>
                                </td>
                                   
                            </tr>
                        <?php
                        }
                        ?> <!---- END row bikewarranty ---->
                         <?php  // row helmet --------------------------------------------------------
                        if(array_key_exists('helmet',$extra_variation_name_price)) {           
                        ?>
                            <tr>  
                                <th>
                                    <?php
                                    echo __('Helmet' ,'wm-child-verdenatura');
                                    ?>
                                </th>
                                    
                                <td>
                                <?php
                                    echo $extra_variation_name_price['helmet'];
                                    ?>
                                </td>
                                   
                            </tr>
                        <?php
                        }
                        ?> <!---- END row helmet ---->
                    </tbody>
            </table>
            <?php
            }  //----------- END hotel product table
            ?>
        </div><!---- END  -------- quote extra -->
        <div class="prezzi-description">
            <?php 
                $vn_part_pr = get_field( 'vn_part_pr' );
                if ($vn_part_pr) {
                echo $vn_part_pr;
                }
            ?>
        </div>
    </div>

    <div id="tabs-5">
        <p class="come-arrivare">
            <?php
            $vn_come_arrivare = get_field('vn_come_arrivare');
            if ( $vn_come_arrivare )
                echo $vn_come_arrivare;
            ?>
        </p>
    </div>
</div>


    <script>
        ( function($) {
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

    $html = ob_get_clean();
    return $html;
}
