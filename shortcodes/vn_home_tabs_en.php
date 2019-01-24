<?php
/**
 * Created by PhpStorm.
 * User: Silvia E.
 * Date: 19/01/19
 * Time: 16:11
 */




add_shortcode( 'vn_home_tabs_en', 'vn_render_home_tabs_shortcode_en' );
function vn_render_home_tabs_shortcode_en( $atts )
{

    ob_start();
    ?>




    <div id="tabs" class="vn-tab-home">
    <ul class="tabs-home-en-tab">
        <li class="hiking"><a href="#tabs-1" style="border-right: 1px solid #ccc; background-color: white; color: #ff9933; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/piedi.png" class="piedi-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">HIKING</a></li>
        <li class="bike-boat"><a href="#tabs-2" style="border-right: 1px solid #ccc; background-color: white; color: #990066; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/bici-barca.png" class="bici-barca-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">BY BIKE AND BOAT</a></li>
        <li class="bike-tour"><a href="#tabs-3" style="border-right: 1px solid #ccc;  background-color: white; color: #ca0a1d; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/bicicletta.png" class="bici-img" style="width: 2.5em; vertical-align: bottom; margin-right: 20px;">BY BIKE</a></li>
        <li class="families"><a href="#tabs-4" style="border-right: 1px solid #ccc;  background-color: white; color: #00cccc; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/famiglia.png" class="famiglia-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">FOR FAMILIES</a></li>
        <li class="discove"><a href="#tabs-5" style="border-right: 1px solid #ccc; background-color: white; color: #b06131; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/esplorazione.png" class="esplorazione-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">DISCOVERY</a></li>
        <li class="weeke"><a href="#tabs-6" style="background-color: white; color: #ffc400; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/weekend.png" class="weekend-img" style="width: 2.3em;vertical-align: bottom; margin-right: 20px;">WEEKEND</a></li>
    </ul>



    <div id="tabs-1">
        <p style="color: #666;">
        <img src="/wp-content/themes/wm-child-verdenatura/images/piedi.png" style="float: left; padding: 15px 10px 0 0;">
       <h2> hiking</h2>
        Hiking… we think about it not only as an activity to be performed on hills or mountains but especially as a more human and direct way to stay in contact with nature and visit places.
        </p>
        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="89" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-2">
        <p style="color: #666;"> <img src="/wp-content/themes/wm-child-verdenatura/images/bici-barca.png" style="float: left; padding: 15px 10px 0 0;"> <h2>by bike and boat</h2>
        A trip which combines land and sea, in search of natural treasures and cultural heritage which you can discover along the coast on board a caique.
        </p>
        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="87" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-3" class="bici-content">
        <p style="color: #666; "><img src="/wp-content/themes/wm-child-verdenatura/images/bicicletta.png" style="float: left; padding: 15px 10px 0 0;"> <h2>by bike</h2>

        All around Europe on pedals, itineraries by bike usually taking a week during which the slowly rhythm of your going-on will let you enjoy each moment of your journey.
        </p>
        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="90" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-4">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/famiglia.png" style="float: left; padding: 15px 10px 0 0;"> <h2>for families</h2>
        Created for families, to suit their needs. Itineraries, stages, timing, are planned so that children, whatever their age is, can enjoy their time and discover new places.        </p>

        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="88" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-5">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/esplorazione.png" style="float: left; padding: 15px 10px 0 0;"> <h2>discovery</h2>

        Each season our guides scout and test new routes. If you have a pioneering spirit and a little training you can go with them on these trips. Services will be mostly booked and organized but be prepared for some unexpected changes along the way. An unmissable opportunity for those looking for a bit more adventure!        </p>
    </div>

    <div id="tabs-6">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/weekend.png"style="float: left; padding: 15px 10px 0 0;"><h2>weekend</h2>
        Weekend and short breaks: some hiking and cycling getaways designed to make your trip across Europe even more memorable.
        </p>

        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="91" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>

    </div>

    <script>
        ( function($) {
            $( "#tabs" ).tabs();
        } )(jQuery);

        jQuery(function(){
            window.et_pb_smooth_scroll = () => {};
        });
    </script>


    <?php

    $html = ob_get_clean();
    return $html;
}
