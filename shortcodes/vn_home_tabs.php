<?php


add_shortcode( 'vn_home_tabs', 'vn_render_home_tabs_shortcode' );
// [bartag foo="foo-value"]
function vn_render_home_tabs_shortcode( $atts ) {

    ob_start();
    ?>

<script>
jQuery( function($) {
    $( "#tabs" ).tabs();
  } );
  </script>



<div id="tabs" class="vn-tab-home">
  <ul>
      <li><a href="#tabs-1"><img src="/wp-content/themes/wm-child-verdenatura/images/bicicletta.png"> IN BICICLETTA</a></li>
      <li><a href="#tabs-2"><img src="/wp-content/themes/wm-child-verdenatura/images/bici-barca.png">IN BICI E BARCA</a></li>
      <li><a href="#tabs-3"><img src="/wp-content/themes/wm-child-verdenatura/images/piedi.png">A PIEDI</a></li>
      <li><a href="#tabs-4"><img src="/wp-content/themes/wm-child-verdenatura/images/famiglia.png">IN FAMIGLIA</a></li>
      <li><a href="#tabs-5"><img src="/wp-content/themes/wm-child-verdenatura/images/esplorazione.png">ESPLORAZIONE</a></li>
      <li><a href="#tabs-6"><img src="/wp-content/themes/wm-child-verdenatura/images/weekend.png">WEEKEND</a></li>
  </ul>

    <div id="tabs-1">
     <p></p>
    </div>

    <div id="tabs-2">
      <p></p>
    </div>

    <div id="tabs-3">
      <p></p>
    </div>

    <div id="tabs-4">
        <p></p>
    </div>

    <div id="tabs-5">
        <p></p>

              <div id="tabs-6">
<p></p>
              </div>
</div>



<?php

    $html = ob_get_clean();
    return $html;
}
