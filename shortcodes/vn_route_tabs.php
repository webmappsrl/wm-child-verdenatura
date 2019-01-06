<?php


add_shortcode( 'vn_route_tabs', 'vn_render_route_tabs_shortcode' );
// [bartag foo="foo-value"]
function vn_render_route_tabs_shortcode() {

ob_start();
?>




<div id="tabs">
  <ul>
    <li><a href="#tabs-1" style="border-right: solid 2px #0F7A68;">DESCRIZIONE</a></li>
    <li><a href="#tabs-2" style="border-right: solid 2px #0F7A68;">PROGRAMMA</a></li>
    <li><a href="#tabs-3" style="border-right: solid 2px #0F7A68;">CARATTERISTICHE</a></li>
      <li><a href="#tabs-4" style="border-right: solid 2px #0F7A68;">PARTENZE E QUOTE</a></li>
      <li><a href="#tabs-5" >COME ARRIVARE</a></li>
  </ul>

  <div id="tabs-1">
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
        <p class="part-e-pre">
            <?php
            $vn_part_pr = get_field('vn_part_pr');
            if ( $vn_part_pr )
                echo $vn_part_pr;
            ?>
        </p>
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
