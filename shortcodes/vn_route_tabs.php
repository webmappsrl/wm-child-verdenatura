<?php


add_shortcode( 'vn_route_tabs', 'vn_render_route_tabs_shortcode' );
// [bartag foo="foo-value"]
function vn_render_route_tabs_shortcode() {

ob_start();
?>




<div id="tabs" class="vn-tab-route">
  <ul>
    <li><a href="#tabs-1" style="border-right: solid 2px #0F7A68;">DESCRIZIONE</a></li>
    <li><a href="#tabs-2" style="border-right: solid 2px #0F7A68;">PROGRAMMA</a></li>
    <li><a href="#tabs-3" style="border-right: solid 2px #0F7A68;">CARATTERISTICHE</a></li>
      <li><a href="#tabs-4" style="border-right: solid 2px #0F7A68;">PARTENZE E QUOTE</a></li>
      <li><a href="#tabs-5" >COME ARRIVARE</a></li>
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
        <div class="durata-preventivo">
            <?php
            $days = get_field('vn_durata');
            if ( $days )
            {
                $nights = $days - 1;
                echo "<p class='dur-txt'>";
                echo __( 'Duration: ' , 'wm-child-verdenatura' ) . ": $days" . __( 'days' , 'wm-child-verdenatura' ) . "/$nights" . __( 'nights' , 'wm-child-verdenatura' ) ;
                $vn_note_dur = get_field( 'vn_note_dur' );
                if ( $vn_note_dur )
                    echo "<span class='webmapp_route_duration_notes'> ($vn_note_dur)</span>";
                echo "</p>";
            }
            ?>
            <?php
            echo "<p class='durata-txt'>";
            echo __('Departures: ' ,'wm-child-verdenatura');?>
            <span class="content-partenze">
                                <?php
                                $vn_part_sum = get_field('vn_part_sum');
                                if ($vn_part_sum)
                                    echo $vn_part_sum;
                                echo "</p>"

                                ?>
                                </span>
        </div>

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
