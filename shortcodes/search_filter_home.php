<?php


add_shortcode( 'vn_home_search', 'vn_render_home_search_filters' );
function vn_render_home_search_filters( $atts ) {

    ob_start();
    ?>

    <div class="search-container-grid" >
    <!-- <div class="dropdown">
            <input type="checkbox" name="fwp_self_guided" value="1"> Viaggi individuali<br><input type="checkbox" name="fwp_guided" value="1"> Viaggi guidati<br>
    </div> -->
    <select class="dropdown-viaggi">
            <option selected disabled><?php echo __('Formula','wm-child-verdenatura'); ?></option>
            <option  data-name="fwp_self_guided" value="1"><?php echo __('Self-guided Trips','wm-child-verdenatura'); ?></option>
            <option  data-name="fwp_guided" value="1"><?php echo __('Guided Trips','wm-child-verdenatura'); ?></option>
    </select>
        <?php 
        $type = __('Type','wm-child-verdenatura');
        $Destination = __('Destination','wm-child-verdenatura');
        $args = array(
            'show_option_all'    => '',
            'show_option_none'   => $type,
            'option_none_value'  => '',
            'orderby'            => 'name',
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'child_of'           => 0,
            'exclude'            => array(116),
            'include'            => '',
            'echo'               => 1,
            'selected'           => 0,
            'hierarchical'       => 0,
            'name'               => 'fwp_tipologia',
            'id'                 => '',
            'class'              => 'postform',
            'taxonomy'           => 'activity',
            'hide_if_empty'      => false,
            'value_field'	     => 'slug',
        );
        wp_dropdown_categories( $args ); 
        ?>
        <?php 
        $args = array(
            'show_option_all'    => '',
            'show_option_none'   => $Destination,
            'option_none_value'  => '',
            'orderby'            => 'name',
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'child_of'           => 0,
            'exclude'            => '',
            'include'            => '',
            'echo'               => 1,
            'selected'           => 0,
            'hierarchical'       => 0,
            'name'               => 'fwp_places_to_go',
            'id'                 => '',
            'class'              => 'postform',
            'taxonomy'           => 'where',
            'hide_if_empty'      => false,
            'value_field'	     => 'slug',
        );
        wp_dropdown_categories( $args ); 
        ?>
        <div class="box search-button"><button id="vn-search-search" ><?php echo __('SEARCH','wm-child-verdenatura'); ?></button><button id="vn-search-map"><i class="material-icons">language</i></button></div>
    </div>

        <script>
            var url1;
            var url2;
            var url3;
            var val1;
            var val2;
            var val3;
            var main_url;
            var pathname = window.location.href;
            var url = new URL(pathname);
            var lang = url.searchParams.get("lang");

            if ( lang ) {
                main_url = window.location.protocol + "//" + window.location.host + "/" + "route/?lang=en&";
            } else {
                main_url = window.location.protocol + "//" + window.location.host + "/" + "route?";
            }

            jQuery('.dropdown-viaggi').on('change', function() {
                
                    var name1 = jQuery(this).find(':selected').data('name'); 
                    val1 = jQuery(this).val(); 
                    url1 = name1 + "=" + val1;
            });

            jQuery('#fwp_tipologia').on('change', function() {
                
                var name2 = "fwp_tipologia"; 
                val2 = jQuery(this).val(); 
                url2 = name2 + "=" + val2;
             });
            
            jQuery('#fwp_places_to_go').on('change', function() {
                
                var name3 = "fwp_places_to_go"; 
                val3 = jQuery(this).val(); 
                url3 = name3 + "=" + val3;
             });
            
            jQuery('#vn-search-search').click(function(){
                location.href = main_url + (val1 != null ? url1 +"&" : "" ) + ( val2 != null ? url2 +"&" : "" )+ (val3 != null ? url3 : "");
            });

            jQuery('.material-icons').click(function(){
                location.href = main_url + (val1 != null ? url1 +"&" : "" ) + ( val2 != null ? url2 +"&" : "" )+ (val3 != null ? url3 : "") + "&fwp_map=1";
            });
        </script>

    <?php

    $html = ob_get_clean();
    return $html;
}
